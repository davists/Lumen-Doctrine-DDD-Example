<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Infrastructure\Persistence\Doctrine\Repositories;

use Doctrine\ORM\QueryBuilder;
/**
 * Classe criada para auxiliar na construção de querys personalizadas
 * Extende o QueryBuilder do Doctrine
 * Documentação do QueryBuilder: http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/reference/query-builder.html
 *
 * @author nicolas
 */
class CustomQueryBuilder extends QueryBuilder
{
    /**
     * array para tratar ordenação de um campo em uma entitdade relacionada
     * ex: ['city'=>'c.name',state='s.name']
     * também pode ser qualque valor usado no select da consulto
     * ex: ['checked'=>'checked']
     */
    private $joinSort = [];
    
    /**
     * array para tratar filtro de um campo em uma entitdade relacionada
     * ex: ['city'=>'c.name',state=>'s.name']
     */
    private $joinFilter = []; 
    
    /**
     * field para fazer pesquisa de texto em diversos campos
     */
    private $generalFilter;
    
    /**
     * array de campos a serem pesquisados pelo filtro geral
     */
    private $arraySearchFields = [];
    
    
    public function __construct(\Doctrine\ORM\EntityManagerInterface $em) 
    {
        parent::__construct($em);
    }
    
    /**
     * Setar algumas configurações passando array
     * útil para não ter muitos parametros no método que for utilizado
     */
    public function setOptions(array $options)
    {
        if(array_key_exists('joinSort', $options))
        {
            $this->setJoinSort($options['joinSort']);
        }
        foreach ($options as $option => $value){
            switch ($option){
                case 'fields': $this->fields($value);break;
                case 'relations': $this->relations($value);break;
                case 'filters': $this->filter($value);break;
                case 'sort': $this->urlSort($value);break;
            }
        }
        return $this;
    }
    
    #################################
    # MÉTODOS SIMPLES ADICIONAIS
    #################################
    public function andWhereIn($field,$arrIn)
    {
        $this->andWhere($this->expr()->in($field,$arrIn));
        return $this;
    }
    
    #################################
    # SELECIONAR ENTIADE PRINCIPAL
    #################################
    public function from($from, $alias, $indexBy = null, $selectEntity = null) 
    {
        parent::from($from, $alias, $indexBy);
        if($selectEntity){
            $this->select($this->getRootAlias());
        }
        return $this;
    }

    #################################
    # SELECIONAR CAMPOS NA ENTIDADE PRINCIPAL
    #################################
    public function fields($fields)
    {
        $this->resetDQLPart('select');
        if($fields && $fields != '*'){
            $this->addSelect("partial ".$this->getRootAlias().".{id,$fields}");
            return $this;
        }
        $this->addSelect($this->getRootAlias());
        return $this;
    }
    
    #################################
    # FILTRO
    #################################
    public function setJoinFilter(array $joinFilter)
    {
        $this->joinFilter = $joinFilter;
        return $this;
    }
    
    public function setGeneralFilter($generalFilter, array $arraySearchFields)
    {
        $this->generalFilter = $generalFilter;
        $this->arraySearchFields = $arraySearchFields;
        return $this;
    }


    public function filter(array $filter, array $joinFilter=[])
    {
        if(count($joinFilter)){
            $this->setJoinFilter($joinFilter);
        }
        
        foreach ($filter as $field => $value){
            if($field == $this->generalFilter){
                return $this->generalFilter($value);
            }
            
            if(array_key_exists($field, $this->joinFilter))
            {
                $aliasField = $this->joinFilter[$field];
            }else{
                $aliasField = $this->getRootAlias().'.'.$field;
            }
            
            
            if(substr($value, 0, 1) == '*' || substr($value, -1, 1) == '*'){
                $value = str_replace('*', '%', $value);
                $this->andWhere($this->expr()->like($aliasField, "'$value'"));
                continue;
            }
            
            if(substr($value, 0, 1) == '>'){
                $this->andWhere($this->expr()->gt($aliasField, "'".substr($value,1)."'"));
                continue;
            }
            
            if(substr($value, 0, 1) == '<'){
                $this->andWhere($this->expr()->lt($aliasField, "'".substr($value,1)."'"));
                continue;
            }
            
            if(strpos($value, ',')){
                $this->andWhere($this->expr()->in($aliasField,explode(',',$value)));
                continue;
            }
            
            if($value == 'null'){
                $this->andWhere($this->expr()->isNull($aliasField));
                continue;
            }
            
            $this->andWhere($this->expr()->eq($aliasField, "'$value'"));
        }
        return $this;
    }
    
    public function generalFilter($value)
    {
        if(substr($value, 0, 1) == '*' || substr($value, -1, 1) == '*'){
            $value = str_replace('*', '%', $value);
            $where = "";
            foreach($this->arraySearchFields as $key => $searchField){
                if($key > 0){
                    $where .= " OR ";
                }
                $where .= "$searchField like '$value'";
            }
            $this->andWhere($where);
            return $this;
        }
        
        $where = "";
        foreach($this->arraySearchFields as $key => $searchField){
            if($key > 0){
                $where .= " OR ";
            }
            $where .= "$searchField = '$value'";
        }
        $this->andWhere($where);
        return $this;
    }

    
    #################################
    # ORDENAÇÃO
    #################################
    /**
     * Recebe string para ordenação setado na ulr
     * ex: name,-value
     */
    public function urlSort($urlSort, array $joinSort=[])
    {
        if(!$urlSort){
            return $this;
        }
        
        if(count($joinSort)){
            $this->setJoinSort($joinSort);
        }
        $arrSort = explode(',', $urlSort);
        
        foreach ($arrSort as $sort){
            if(substr($sort, 0, 1) == '-'){
                $this->addUrlSort(substr($sort,1), 'DESC');
                continue;
            }
            $this->addUrlSort($sort, 'ASC');
        }
        return $this;
    }
    
    public function setJoinSort(array $joinSort)
    {
        $this->joinSort = $joinSort;
        return $this;
    }


    /**
     * Adiciona ordenação verificando se tem alguma regra para relacionamento
     */
    private function addUrlSort(string $sort, string $order)
    {
        if(array_key_exists($sort, $this->joinSort)){
            $sortAlias = $this->joinSort[$sort];
            $this->addOrderBy($sortAlias, $order);
            return $this;
        }
        $sortAlias = $this->getRootAlias().'.'.$sort;
        $this->addOrderBy($sortAlias, $order);
        return $this;
    }
    
    #################################
    # TRAZER RELACIONAMENTOS
    #################################
    public function relations(array $relations)
    {
        foreach($relations as $relation => $fields){
            $this->leftJoin($this->getRootAlias().'.'.$relation, $relation);
             if($fields == '*'){
                $this->addSelect($relation);
                continue;
            }
            $this->addSelect('partial '.$relation.'.{id,'.$fields.'}');
        }
        return $this;
    }
}

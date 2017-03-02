<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 2/26/17
 * Time: 12:35 AM
 */

namespace Infrastructure\Doctrine\Repositories\Manager;

use Domain\Manager\Entities\Manager;
use Doctrine\ORM\EntityManager;
use Domain\Manager\Contracts\ManagerRepositoryContract;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\ORM\QueryBuilder;
use Doctrine\DBAL\Query\Expression\CompositeExpression;

/**
 * Class ManagerRepository
 * @package Infrastructure\Doctrine\Repositories\Manager
 */
class ManagerRepository implements ManagerRepositoryContract
{
    /**
     * @var string
     */
    private $class = Manager::class;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * ManagerRepository constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * @param Manager $manager
     */
    public function create(Manager $manager)
    {
        $this->em->persist($manager);
        $this->em->flush();
    }

    /**
     * @param Manager $manager
     * @param $data
     */
    public function update(Manager $manager, $data)
    {
        $manager->setName($data['name']);
        $manager->setEmail($data['email']);
        $manager->setPassword($data['password']);
        $this->em->persist($manager);
        $this->em->flush();
    }

    /**
     * @param Manager $manager
     */
    public function delete(Manager $manager)
    {
        $this->em->remove($manager);
        $this->em->flush();
    }

    /**
     * create Manager
     * @return Manager
     */
    public function load($data)
    {
        return new Manager($data);
    }

    /**
     * @param $id
     * @return null|object
     */
    public function findById($id)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'id' => $id
        ]);
    }

    /**
     * @param $email
     * @param $password
     * @return Manager
     */
    public function findByEmail($email)
    {
        return $this->em->getRepository($this->class)->findOneBy([
            'email'=>$email
        ]);
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $tasks = $this->em->getRepository($this->class)->findAll();
        return $tasks;
    }

    /**
     * @param Manager $manager
     * @return array
     */
    public function toArray(Manager $manager)
    {
        return [
            'id' => $manager->getId(),
            'name' => $manager->getName(),
            'email' => $manager->getEmail()
        ];
    }

    /**
     * @param $dql
     * @param int $page
     * @param int $limit
     * @return Paginator
     */
    public function paginate($dql, $page = 1, $limit = 20)
    {
        $query = $this->em->createQuery($dql)
            ->setFirstResult($limit * ($page - 1))
            ->setMaxResults($limit);

        $paginator = new Paginator($query, $fetchJoinCollection = true);

        return $this->paginatorToArray($paginator);
    }

    /**
     * @param Paginator $paginator
     * @return array
     */
    public function paginatorToArray(Paginator $paginator)
    {
        $arrayResponse = [];

        foreach($paginator as $manager){
            $arrayResponse[] = $this->toArray($manager);
        }

        return $arrayResponse;
    }


    /**
     * @param array $filter
     * @return array
     */
    public function findByCriteria(array $filter)
    {
        $criteria = $this->addCriteria($filter);
        $result = $this->em->getRepository($this->class)->matching($criteria)->toArray();

        $arrayResponse = [];

        foreach ($result as $manager){
            $arrayResponse[]  = $this->toArray($manager);
        }

        return $arrayResponse;
    }

    /**
     * @param $filter
     * @return Criteria
     */
    public function addCriteria($filter)
    {
        $criteria = Criteria::create();
        $expr = Criteria::expr();

        if (count($filter)) {
            foreach ($filter as $expression => $comparison) {
                if(is_array($comparison[0])){
                    foreach ($comparison as $statement){

                        list($field, $operator, $value) = $statement;

                        if($field === "createdAt" || $field === "updatedAt"){
                            $value = new \DateTime($value);

                        }

                        if ($expression === 'or') {
                            $criteria->orWhere($expr->{$operator}($field,$value));
                        }

                        if ($expression === 'and') {
                            $criteria->andWhere($expr->{$operator}($field,$value));
                        }
                    }
                }
                else{
                    list($field, $operator, $value) = $comparison;
                    $criteria->where($expr->{$operator}($field,$value));
                }
            }
        }

        //dd($criteria);
        return $criteria;
    }

    //teste jsob
    //{"filter":{"or":[["field1","like","%field1Value%"],["field2","like","%field2Value%"]],"and":[["field3","eq",3],["field4","eq","four"]],"0":["field5","neq",5]}}

    //        $criteria = Criteria::create()
//            ->where(Criteria::expr()->eq("birthday", "1982-02-17"))
//            ->orderBy(array("username" => Criteria::ASC))
//            ->setFirstResult(0)
//            ->setMaxResults(20)
//        ;

    /**
     * Recursively takes the specified criteria and adds too the expression.
     *
     * The criteria is defined in an array notation where each item in the list
     * represents a comparison <fieldName, operator, value>. The operator maps to
     * comparison methods located in ExpressionBuilder. The key in the array can
     * be used to identify grouping of comparisons.
     *
     * @example
     * $criteria = array(
     *      'or' => array(
     *          array('field1', 'like', '%field1Value%'),
     *          array('field2', 'like', '%field2Value%')
     *      ),
     *      'and' => array(
     *          array('field3', 'eq', 3),
     *          array('field4', 'eq', 'four')
     *      ),
     *      array('field5', 'neq', 5)
     * );
     *
     * $qb = new QueryBuilder();
     * addCriteria($qb, $qb->expr()->andX(), $criteria);
     * echo $qb->getSQL();
     *
     * // Result:
     * // SELECT *
     * // FROM tableName
     * // WHERE ((field1 LIKE '%field1Value%') OR (field2 LIKE '%field2Value%'))
     * // AND ((field3 = '3') AND (field4 = 'four'))
     * // AND (field5 <> '5')
     *
     * @param QueryBuilder $qb
     * @param CompositeExpression $expr
     * @param array $criteria
     */


}
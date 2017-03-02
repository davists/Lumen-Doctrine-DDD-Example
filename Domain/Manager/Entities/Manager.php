<?php

namespace Domain\Manager\Entities;

/**
 * Manager
 */
class Manager
{
    /**
     * @var integer
     */
    private $companyId;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     */
    private $id;

    /**
     * Manager constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->setEmail($data['email']);
        $this->setName($data['name']);
        $this->setPassword($data['password']);
        $this->setCompanyId(1);
        $this->setCreatedAt();
    }

    /**
     * @param int $companyId
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password,PASSWORD_DEFAULT);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
        //return $this->createdAt->format('Y-m-d H:i:s');
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * @param \DateTime $createdAt
     */
    public function setCreatedAt()
    {
        $this->createdAt = new \DateTime();
    }



}


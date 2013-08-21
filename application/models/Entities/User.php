<?php

namespace Entities;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @Entity
 * @Table(name="users")
 * @property int $id
 * @property int $username
 * @property int $password
 * @property int $salt
 * @property int $email
 * @property int $dateCreated
 * @property int $flagDeleted
 * @property int $displayName
 * @property int $state
 * @property int $firstname
 * @property int $lastname
 * @property int $flagAdmin
 * @property int $userRole
 */
class User
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /**
     * @var string
     *
     * @Column(name="username", type="string", length=50, precision=0, scale=0, nullable=true, unique=true)
     */
    protected $username;

    /**
     * @var string
     *
     * @Column(name="password", type="string", length=70, precision=0, scale=0, nullable=false, unique=false)
     */
    protected $password;

    /**
     * @var string
     *
     * @Column(name="salt", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $salt;

    /**
     * @var string
     *
     * @Column(name="email", type="string", precision=0, scale=0, nullable=false, unique=true)
     */
    protected $email;

    /**
     * @var integer
     *
     * @Column(name="datecreated", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $dateCreated;

    /**
     * @var integer
     *
     * @Column(name="lastlogindate", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $lastLoginDate;

    /**
     * @var string
     *
     * @Column(name="lastloginip", type="string", scale=0, nullable=false, unique=false)
     */
    protected $lastLoginIP;

    /**
     * @var integer
     *
     * @Column(name="registrationdate", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $registrationDate;

    /**
     * @var string
     *
     * @Column(name="registrationip", type="string", scale=0, nullable=false, unique=false)
     */
    protected $registrationIP;

    /**
     * @var integer
     *
     * @Column(name="flagdeleted", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $flagDeleted;

    /**
     * @var string
     *
     * @Column(name="displayname", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $displayName;

    /**
     * @var string
     *
     * @Column(name="flagactivated", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $flagActivated;

    /**
     * @var string
     *
     * @Column(name="firstname", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $firstname;

    /**
     * @var string
     *
     * @Column(name="lastname", type="string", precision=0, scale=0, nullable=true, unique=false)
     */
    protected $lastname;

    /**
     * @var string
     *
     * @Column(name="flagadmin", type="integer", precision=0, scale=0, nullable=false, unique=false)
     */
    protected $flagAdmin = 0;

}
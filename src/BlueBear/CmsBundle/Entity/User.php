<?php

namespace BlueBear\CmsBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="cms_user")
 * @ORM\Entity(repositoryClass="BlueBear\CmsBundle\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * User unique id
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * User name
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="username")
     */
    protected $username;

    /**
     * User canonical name
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="username_canonical")
     */
    protected $usernameCanonical;

    /**
     * User email
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="email")
     */
    protected $email;

    /**
     * User canonical email
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="email_canonical")
     */
    protected $emailCanonical;

    /**
     * User enable state
     *
     * @var boolean
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;

    /**
     * User password salt
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="salt")
     */
    protected $salt;

    /**
     * User password
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="password")
     */
    protected $password;

    /**
     * User name
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="last_login")
     */
    protected $lastLogin;

    /**
     * Indicate if the user is locked
     *
     * @var boolean
     * @ORM\Column(type="boolean", name="locked")
     */
    protected $locked = false;

    /**
     * Indicate if the user is expired
     *
     * @var boolean
     * @ORM\Column(type="boolean", name="expired")
     */
    protected $expired = false;

    /**
     * User expiration date
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="expires_at", nullable=true)
     */
    protected $expiresAt;

    /**
     * User confirmation token
     *
     * @var string
     * @ORM\Column(type="string", length=255, name="confirmation_token")
     */
    protected $confirmationToken;

    /**
     * User last password request date
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="password_requested_at")
     */
    protected $passwordRequestedAt;

    /**
     * User roles
     *
     * @var Role[]
     * @ORM\Column(type="array", name="roles")
     */
    protected $roles = [];

    /**
     * Indicate if the user creadentials are expired
     *
     * @var boolean
     * @ORM\Column(type="boolean", name="credentials_expired")
     */
    protected $credentialsExpired = false;

    /**
     * User credentials expiration date
     *
     * @var DateTime
     * @ORM\Column(type="datetime", name="credentials_expire_at")
     */
    protected $credentialsExpireAt;

    /**
     * @ORM\OneToMany(targetEntity="BlueBear\CmsBundle\Entity\Article", mappedBy="author")
     */
    protected $articles;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        $roles = [];

        foreach ($this->roles as $role) {
            $roles[] = new Role($role);
        }
        return $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {

    }

    /**
     * @return string
     */
    public function getConfirmationToken()
    {
        return $this->confirmationToken;
    }

    /**
     * @return string
     */
    public function getUsernameCanonical()
    {
        return $this->usernameCanonical;
    }

    /**
     * @param string $usernameCanonical
     * @return User
     */
    public function setUsernameCanonical($usernameCanonical)
    {
        $this->usernameCanonical = $usernameCanonical;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailCanonical()
    {
        return $this->emailCanonical;
    }

    /**
     * @param string $emailCanonical
     * @return User
     */
    public function setEmailCanonical($emailCanonical)
    {
        $this->emailCanonical = $emailCanonical;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param boolean $enabled
     * @return User
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param DateTime $lastLogin
     * @return User
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isLocked()
    {
        return $this->locked;
    }

    /**
     * @param boolean $locked
     * @return User
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isExpired()
    {
        return $this->expired;
    }

    /**
     * @param boolean $expired
     * @return User
     */
    public function setExpired($expired)
    {
        $this->expired = $expired;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param DateTime $expiresAt
     * @return User
     */
    public function setExpiresAt($expiresAt)
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getPasswordRequestedAt()
    {
        return $this->passwordRequestedAt;
    }

    /**
     * @param DateTime $passwordRequestedAt
     * @return User
     */
    public function setPasswordRequestedAt($passwordRequestedAt)
    {
        $this->passwordRequestedAt = $passwordRequestedAt;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCredentialsExpired()
    {
        return $this->credentialsExpired;
    }

    /**
     * @param boolean $credentialsExpired
     * @return User
     */
    public function setCredentialsExpired($credentialsExpired)
    {
        $this->credentialsExpired = $credentialsExpired;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCredentialsExpireAt()
    {
        return $this->credentialsExpireAt;
    }

    /**
     * @param DateTime $credentialsExpireAt
     * @return User
     */
    public function setCredentialsExpireAt($credentialsExpireAt)
    {
        $this->credentialsExpireAt = $credentialsExpireAt;
        return $this;
    }

    public function __toString()
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
}

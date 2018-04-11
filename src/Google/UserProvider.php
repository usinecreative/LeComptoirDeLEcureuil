<?php

namespace AppBundle\Google;

use BlueBear\CmsBundle\Entity\User;
use BlueBear\CmsBundle\Repository\UserRepository;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\OAuthAwareUserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class UserProvider implements OAuthAwareUserProviderInterface, UserProviderInterface
{
    /**
     * @var array
     */
    private $allowedUserEmails;
    
    /**
     * @var UserRepository
     */
    private $userRepository;
    
    /**
     * GoogleUserProvider constructor.
     *
     * @param array          $allowedUserEmails
     * @param UserRepository $userRepository
     */
    public function __construct(array $allowedUserEmails, UserRepository $userRepository)
    {
        $this->allowedUserEmails = $allowedUserEmails;
        $this->userRepository = $userRepository;
    }
    
    /**
     * Loads the user by a given UserResponseInterface object.
     *
     * @param UserResponseInterface $response
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        if (!in_array($response->getEmail(), $this->allowedUserEmails)) {
            throw new UsernameNotFoundException();
        }
    
        $user = $this
            ->userRepository
            ->findOneBy([
                'email' => $response->getEmail(),
            ])
        ;
        $user->setProfilePicture($response->getProfilePicture());
        
        if ($user === null) {
            $user = new User();
            $user->setUsername($response->getUsername());
            $user->setUsernameCanonical($response->getUsername());
            $user->setEmail($response->getEmail());
            $user->setEmailCanonical($response->getEmail());
            $user->setFirstName($response->getFirstName());
            $user->setLastName($response->getLastName());
            $user->setSalt('google');
            $user->setPassword('google');
    
            $this
                ->userRepository
                ->save($user)
            ;
        }
    
        $user->setRoles([
            'ROLE_ADMIN',
        ]);
        
        return $user;
    }
    
    /**
     * Loads the user for the given username.
     *
     * This method must throw UsernameNotFoundException if the user is not
     * found.
     *
     * @param string $username The username
     *
     * @return UserInterface
     *
     * @throws UsernameNotFoundException if the user is not found
     */
    public function loadUserByUsername($username)
    {
        throw new UsernameNotFoundException();
    }
    
    /**
     * Refreshes the user for the account interface.
     *
     * It is up to the implementation to decide if the user data should be
     * totally reloaded (e.g. from the database), or if the UserInterface
     * object can just be merged into some internal array of users / identity
     * map.
     *
     * @param UserInterface $user
     *
     * @return UserInterface
     *
     * @throws UnsupportedUserException if the account is not supported
     */
    public function refreshUser(UserInterface $user)
    {
        return $user;
    }
    
    /**
     * Whether this provider supports the given user class.
     *
     * @param string $class
     *
     * @return bool
     */
    public function supportsClass($class)
    {
        return User::class;
    }
}

<?php
/**
 * Created by PhpStorm.
 * User: davi
 * Date: 3/1/17
 * Time: 10:38 PM
 */

namespace Domain\Manager\Services;
use Domain\Manager\Contracts\ManagerLoginServiceContract;
use Domain\Manager\Contracts\ManagerRepositoryContract;
use Application\Core\Exceptions\JWTException; //should call a exception from Domain...
use Firebase\JWT\JWT;  //infraestructure dependency

/**
 * Class ManagerLoginService
 * @package Domain\Manager\Services
 */
class ManagerLoginService implements ManagerLoginServiceContract
{
    /**
     * @var ManagerRepositoryContract
     */
    public $repository;

    /**
     * ManagerLoginService constructor.
     * @param ManagerRepositoryContract $repository
     */
    public function __construct(ManagerRepositoryContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param $email
     * @param $password
     * @return array
     */
    public function execute($email, $password){

        $manager = $this->repository->findByEmail($email);

        if (password_verify($password, $manager->getPassword())) {

            //$tokenId    = base64_encode(mcrypt_create_iv(32));
            $issuedAt   = time();
            $notBefore  = $issuedAt + 10;  //Adding 10 seconds
            $expire     = $notBefore + 60; // Adding 60 seconds
            $serverName = getenv('APP_SERVER_NAME');

            /*
             * Create the token as an array
             */
            $data = [
                'iat'  => $issuedAt,         // Issued at: time when the token was generated
                //'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
                'iss'  => $serverName,       // Issuer
                'nbf'  => $notBefore,        // Not before
                'exp'  => $expire,           // Expire
                'data' => [                  // Data related to the signer user
                    'userId'   => $manager->getId(), // userid from the users table
                    'name' => $manager->getName(), // User name
                    'email' => $manager->getEmail(), // User name
                ]
            ];

            $jwt = JWT::encode(
                $data,      //Data to be encoded in the JWT
                getenv('APP_KEY'), // The signing key
                getenv('APP_ENCRYPT_ALGORITHM')  // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
            );

            return ['jwt'=>$jwt];

        } else {

            throw new JWTException('Unauthorized',401);
        }
    }
}
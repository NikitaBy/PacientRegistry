<?php

declare(strict_types=1);

namespace App\Command;

use App\Entity\User;
use App\Enum\RoleEnum;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use function sprintf;

/**
 * Class CreateDefaultAdminCommand
 * TODO refactor!!!
 */
class CreateDefaultAdminCommand extends Command
{
    private const DEFAULT_USERNAME = 'admin';
    //    private const DEFAULT_PASSWORD = '@dm1n';
    private const DEFAULT_PASSWORD = 'admin';

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var UserPasswordEncoder
     */
    private $passwordEncoder;

    /**
     * CreateDefaultAdminCommand constructor.
     *
     * @param EntityManagerInterface       $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder)
    {
        parent::__construct('maintenance:create-default-admin');

        $this->em = $em;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User();

        $user
            ->setUsername(self::DEFAULT_USERNAME)
            ->setPassword($this->passwordEncoder->encodePassword($user, self::DEFAULT_PASSWORD))
            ->addRole(RoleEnum::ROLE_ADMIN);

        $this->em->persist($user);
        $this->em->flush();

        $output->writeln(sprintf('username: %s, password: %s', self::DEFAULT_USERNAME, self::DEFAULT_PASSWORD));

        return 0;
    }
}

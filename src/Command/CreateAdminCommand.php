<?php

declare(strict_types=1);

namespace App\Command;

use App\Enum\RoleEnum;
use App\Factory\UserFactory;
use App\Saver\UserSaver;
use App\Security\PasswordUpdater;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use function bin2hex;
use function random_bytes;
use function sprintf;

/**
 * Class CreateAdminCommand
 */
class CreateAdminCommand extends Command
{
    private const ADMIN_USERNAME = 'admin';
    private const ADMIN_EMAIL = 'admin@admin.com';
    private const ADMIN_PASSWORD = 'admin';
//    private const ADMIN_PASSWORD = '@dm1n_t3st';

    /**
     * @var PasswordUpdater
     */
    private $passwordUpdater;

    /**
     * @var UserFactory
     */
    private $userFactory;

    /**
     * @var UserSaver
     */
    private $userSaver;

    /**
     * CreateAdminCommand constructor.
     *
     * @param PasswordUpdater $passwordUpdater
     * @param UserFactory     $userFactory
     * @param UserSaver       $userSaver
     */
    public function __construct(
        PasswordUpdater $passwordUpdater,
        UserFactory $userFactory,
        UserSaver $userSaver
    ) {
        parent::__construct('administration:create-admin');

        $this->passwordUpdater = $passwordUpdater;
        $this->userFactory = $userFactory;
        $this->userSaver = $userSaver;
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setDescription('Create default admin');
    }

    /**
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $user = $this->userFactory->create();

            $user
                ->setUsername(self::ADMIN_USERNAME)
                ->setEmail(self::ADMIN_EMAIL)
                ->setPlainPassword(self::ADMIN_PASSWORD)
                ->setSalt(bin2hex(random_bytes(4)))
                ->addRole(RoleEnum::ROLE_ADMIN);

            $this->passwordUpdater->updatePassword($user);

            $this->userSaver->save($user);
        } catch (Exception $ex) {
            $output->writeln('Something went wrong :(');

            return 1;
        }

        $output->writeln('Default admin was created');
        $output->writeln(
            sprintf(
                'Credentials: username: %s, password: %s.',
                self::ADMIN_USERNAME,
                self::ADMIN_PASSWORD
            )
        );
        $output->writeln('Strongly recommend to use this user for first login and delete it.');

        return 0;
    }
}

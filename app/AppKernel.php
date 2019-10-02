<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
  public function registerBundles()
  {
    $bundles = array(
      new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
      new Symfony\Bundle\SecurityBundle\SecurityBundle(),
      new Symfony\Bundle\TwigBundle\TwigBundle(),
      new Symfony\Bundle\MonologBundle\MonologBundle(),
      new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
      new Symfony\Bundle\AsseticBundle\AsseticBundle(),
      new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
      new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
      new Braincrafted\Bundle\BootstrapBundle\BraincraftedBootstrapBundle(),
      new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
      new FOS\UserBundle\FOSUserBundle(),
      new WhiteOctober\BreadcrumbsBundle\WhiteOctoberBreadcrumbsBundle(),
      new AppBundle\AppBundle(),
      new SimpleThings\EntityAudit\SimpleThingsEntityAuditBundle(),
      new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
      new JMS\SerializerBundle\JMSSerializerBundle(),
      new Rollerworks\Bundle\PasswordStrengthBundle\RollerworksPasswordStrengthBundle(),
      new Fresh\DoctrineEnumBundle\FreshDoctrineEnumBundle(),
      new Knp\Bundle\SnappyBundle\KnpSnappyBundle(),
      new Doctrine\Bundle\MigrationsBundle\DoctrineMigrationsBundle(),
      new Lexik\Bundle\FormFilterBundle\LexikFormFilterBundle(),
      new MewesK\TwigExcelBundle\MewesKTwigExcelBundle(),
      new ItkDev\DatabaseBundle\ItkDevDatabaseBundle(),
      new Trsteel\CkeditorBundle\TrsteelCkeditorBundle(),
      new FM\ElfinderBundle\FMElfinderBundle(),
    );

    if (in_array($this->getEnvironment(), array('dev', 'test'))) {
      $bundles[] = new Symfony\Bundle\DebugBundle\DebugBundle();
      $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
      $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
      $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
      $bundles[] = new Doctrine\Bundle\FixturesBundle\DoctrineFixturesBundle();
      $bundles[] = new Ddeboer\DataImportBundle\DdeboerDataImportBundle();
    }

    return $bundles;
  }

  public function registerContainerConfiguration(LoaderInterface $loader)
  {
    $loader->load(__DIR__.'/config/config_'.$this->getEnvironment().'.yml');
  }

}

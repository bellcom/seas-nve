<?php
namespace AppBundle\Validator\Constraints;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * @Annotation
 */
class UserEmailValidator extends ConstraintValidator
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var TranslatorInterface $translator
     */
    protected $translator;

    public function __construct(EntityManager $entityManager, TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->translator = $translator;
    }

    public function validate($value, Constraint $constraint)
    {
        /** @var User $existingUser */
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(array('email' => $value));
        if (empty($existingUser) || $existingUser->getId() == $this->context->getObject()->getId()) {
            return;
        }

        $this->context->buildViolation($this->translator->trans('user.messages.error.email', array(
            '%email' => $value,
        )))->addViolation();
    }
}

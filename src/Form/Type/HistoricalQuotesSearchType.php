<?php

namespace App\Form\Type;

use App\Entity\HistoricalQuoteSearchData;
use App\Validator\ConstrainsCompanySymbol;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;

class HistoricalQuotesSearchType extends AbstractType
{
    public const COMPANY_SYMBOL_FIELD = 'companySymbol';
    public const START_DATE_FIELD = 'startDate';
    public const END_DATE_FIELD = 'endDate';
    public const EMAIL_FIELD = 'email';
    public const SUBMIT = 'submit';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addCompanySymbolField($builder);
        $this->addStartDateField($builder);
        $this->addEndDateField($builder);
        $this->addEmailField($builder);
        $this->addSubmit($builder);
    }

    /**
     * @param OptionsResolver $resolver
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => HistoricalQuoteSearchData::class,
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @return void
     */
    protected function addCompanySymbolField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::COMPANY_SYMBOL_FIELD,
            TextType::class,
            [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new ConstrainsCompanySymbol(),
                ],
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @return void
     */
    protected function addStartDateField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::START_DATE_FIELD,
            DateType::class,
            [
                'widget' => 'single_text',
                'required' => true,
                'data' => new \DateTime('midnight'),
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new NotBlank(),
                    new LessThanOrEqual(
                        ['propertyPath' => 'parent.all[' . static::END_DATE_FIELD . '].data'],
                        null,
                        'The value should be less than or equal to the end date.'
                    ),
                    new LessThanOrEqual(
                        new \DateTime('midnight'),
                        null,
                        'The value should be less than or equal to current date'
                    ),
                ],
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @return void
     */
    protected function addEndDateField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::END_DATE_FIELD,
            DateType::class,
            [
                'widget' => 'single_text',
                'required' => true,
                'data' => new \DateTime(),
                'format' => 'yyyy-MM-dd',
                'html5' => false,
                'attr' => ['class' => 'js-datepicker'],
                'constraints' => [
                    new NotBlank(),
                    new GreaterThanOrEqual(
                        ['propertyPath' => 'parent.all[' . static::START_DATE_FIELD . '].data'],
                        null,
                        'The value should be greater than or equal to start date.'
                    ),
                    new LessThanOrEqual(
                        new \DateTime(),
                        null,
                        'The value should be less than or equal to current date'
                    ),
                ],
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @return void
     */
    protected function addEmailField(FormBuilderInterface $builder)
    {
        $builder->add(
            static::EMAIL_FIELD,
            EmailType::class,
            [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
            ]
        );
    }

    /**
     * @param FormBuilderInterface $builder
     * @return void
     */
    protected function addSubmit(FormBuilderInterface $builder)
    {
        $builder->add(
            static::SUBMIT,
            SubmitType::class
        );
    }
}

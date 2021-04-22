<?php

namespace frontend\tests\functional;

use common\fixtures\UserFixture;
use frontend\tests\FunctionalTester;

class ResendVerificationEmailCest
{
    protected $formId = '#resend-verification-email-form';


    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::className(),
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('/site/resend-verification-email');
    }

    protected function formParams($email)
    {
        return [
            'ResendVerificationEmailForm[email]' => $email
        ];
    }

    public function checkPage(FunctionalTester $I)
    {
        $I->see('Выслать письмо с верификацией', 'h1');
        $I->see('Пожалуйста, укажите свой почтовый адрес. На него будет выслано письмо для верификации.');
    }

    public function checkEmptyField(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams(''));
        $I->seeValidationError('Email не может быть пустым.');
    }

    public function checkWrongEmailFormat(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('abcd.com'));
        $I->seeValidationError('Невалидный email-адрес.');
    }

    public function checkWrongEmail(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('wrong@email.com'));
        $I->seeValidationError('Пользователя с таким email не существует.');
    }

    public function checkAlreadyVerifiedEmail(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('test2@mail.com'));
        $I->seeValidationError('Пользователя с таким email не существует.');
    }

    public function checkSendSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, $this->formParams('test@mail.com'));
        $I->canSeeEmailIsSent();
        $I->seeRecord('common\models\User', [
            'email' => 'test@mail.com',
            'username' => 'test.test',
            'status' => \common\models\User::STATUS_INACTIVE
        ]);
        $I->see('Проверьте почтовый ящик, чтобы получить дальнейшие инструкции.');
    }
}

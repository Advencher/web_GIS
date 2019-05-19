<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PhytoIntegrationTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function testMainPageAdmin()
    {
        $email_text = 'test2@gg.com';
        $email_name = 'email';
        $passw_text = '123456';
        $passw_name = 'password';

        $this->visit('/')
            ->type($email_text, $email_name)
            ->type($passw_text, $passw_name)
            ->press('Войти')
            ->see('Веб-ГИС')
            ->see('Применить к таблице')
            ->see('Фитопланктон')
            ->see('Фотосинтетические пигменты')
            ->see('Фильтрация')
            ->see('Выйти')
            ->see('Панель администрирования')
            ->see('За всё время')
            ->see('Очистить');
    }

    public function testAuthWatchUsr()
    {
        $email_text = 'test@gg.com';
        $email_name = 'email';
        $passw_text = '123456';
        $passw_name = 'password';

        $this->visit('/')
            ->type($email_text, $email_name)
            ->type($passw_text, $passw_name)
            ->press('Войти')
            ->dontSee('Отменить')
            ->dontSee('Добавить станцию')
            ->dontSee('Добавить пробу')
            ->dontSee('js/common/grid/rowRemoving.js')
            ->dontSee('Панель администрирования');
    }


    public function testForgotPassw()
    {
        $this->visit('/')
            ->click('Забыли свой пароль?')
            ->see('Отправить ссылку для сброса пароля');
    }




















}

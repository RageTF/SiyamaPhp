<?php

/**
 * @author mrhard
 * @copyright 2010
 */

$this->LANG['install']['title'] = 'demiurgo.cms. Установка';
$this->LANG['install']['urls'] = 'Адреса сайтов, через запятую. all - для всех';
$this->LANG['install']['dir'] = 'Рабочая папка сайта';
$this->LANG['install']['username'] = 'Имя администратора';
$this->LANG['install']['userlogin'] = 'Логин администратора';
$this->LANG['install']['usermail'] = 'e-mail администратора';
$this->LANG['install']['userpass'] = 'Пароль администратора';

$this->LANG['install']['basehost'] = 'хост БД';
$this->LANG['install']['baseport'] = 'порт БД';
$this->LANG['install']['basebase'] = 'база';
$this->LANG['install']['baseuser'] = 'пользователь БД';
$this->LANG['install']['basepass'] = 'пароль БД';
$this->LANG['install']['basepx'] = 'префикс БД';
$this->LANG['install']['hw'] = 'Установить приветствие?';


$this->LANG['install']['error_px'] = 'Данный префикс уже используется в выбраной базе';
$this->LANG['install']['error_nodir'] = 'Вы не указали рабочую папку';
$this->LANG['install']['error_createdir'] = 'Ошибка создания рабочей папки';
$this->LANG['install']['error_noexists'] = 'Рабочая папка уже существует в системе, введите другое название';
$this->LANG['install']['error_user_name'] = 'Вы не заполнили поле Имя администратора';
$this->LANG['install']['error_user_login'] = 'Вы не заполнили поле Логин администратора';
$this->LANG['install']['error_user_mail'] = 'Вы не заполнили поле e-mail администратора';
$this->LANG['install']['error_user_pass'] = 'Вы ввели слишком короткий пароль';

$this->LANG['install']['error_urls']='Укажите адреса сайтов';
$this->LANG['install']['error_urlfilefound']='уже зарегистрирован в системе';
$this->LANG['install']['error_urlfileerror']='ошибка установки';

$this->LANG['install']['true']='Установка успешно завершена! Удалите файл <strong>install.php</strong>';
?>
<?

/**
 * @author Maltsev Vladimir
 * @copyright 2010
 * 
 */


     $this->LANG['compsystem']['configurationcomponentname'] = 'Конфигуратор';
     
     $this->LANG['confcomp']['master'] = 'Мастер  компонентов';
     $this->LANG['confcomp']['list'] = 'Список  компонентов';
 
     $this->LANG['confcomp']['master_error1'] = 'Заполните поле';
     $this->LANG['confcomp']['master_error2'] = 'Директория с таким названием уже присутствует';
     $this->LANG['confcomp']['master_error3'] = 'Таблица с таким названием уже присутствует, введите другой индификатор';
     $this->LANG['confcomp']['master_error4'] = 'Поле с таким названием уже присутствует, введите другой индификатор';
     $this->LANG['confcomp']['master_error5'] = 'Формат поля не поддерживается';

     $this->LANG['confcomp']['master_0'] = 'Создание';
     $this->LANG['confcomp']['master_1'] = 'Описание и иконка';
     $this->LANG['confcomp']['master_2'] = 'Формирование полей';
     $this->LANG['confcomp']['master_3'] = 'Управление шаблонами';
     $this->LANG['confcomp']['master_4'] = 'Экспорт';
     $this->LANG['confcomp']['master_5'] = 'Удаление';
     
      
     $this->LANG['confcomp']['master_0_name'] = 'Название компонента';
    
     $this->LANG['confcomp']['master_0_compname'] = 'Индификатор компонента';
     $this->LANG['confcomp']['master_0_compname_note'] = 'Индификатор должн содержать только латинские символы и цифры, значение должно быть уникаьлным';
     
     $this->LANG['confcomp']['master_0_instal'] = 'Инсталляционный файл (если есть)';
     
     $this->LANG['confcomp']['master_0_instal_error_0']='Ошибка инсталяции: ошибка загрузки файла';
     $this->LANG['confcomp']['master_0_instal_error_1']='Ошибка инсталяции: ошибка открытия архива';
     $this->LANG['confcomp']['master_0_instal_error_2']='Ошибка инсталяции: не найден информационный файл';
     $this->LANG['confcomp']['master_0_instal_error_3']='Ошибка инсталяции: не возможна проверки версии компонента';
     $this->LANG['confcomp']['master_0_instal_error_4']='Ошибка инсталяции: версия компонента не совпадает с версией системы, обновите CMS';
     $this->LANG['confcomp']['master_0_instal_error_5']='Ошибка инсталяции: не найден sql файл';
     $this->LANG['confcomp']['master_0_instal_error_6']='Ошибка инсталяции: компонент неудалось зарегистрировать в реестре';
     $this->LANG['confcomp']['master_0_instal_error_7']='Ошибка инсталяции: ошибка инсталяции SQL файла'; 
     
     $this->LANG['confcomp']['master_1_des'] = 'Описание компонента';
     $this->LANG['confcomp']['master_1_ico'] = 'Иконка компонента';
     $this->LANG['confcomp']['master_1_ico_view'] = 'Текущая иконка — ';
     $this->LANG['confcomp']['master_1_ico_view_note'] = '(Для замены загрузите новую)';
     
     $this->LANG['confcomp']['master_2_nofields'] = 'Список полей пуст';
     $this->LANG['confcomp']['master_2_nofield'] = 'Не найдено';
     $this->LANG['confcomp']['master_2_new'] = 'Создать новое поле';
     $this->LANG['confcomp']['master_2_edit'] = 'Редактировать поле — ';
     $this->LANG['confcomp']['master_2_setting'] = 'Параметры поля — ';
     $this->LANG['confcomp']['master_2_remove'] = 'Удалить поле — ';
     $this->LANG['confcomp']['master_2_remove_title'] = 'Вы действительно хотите удалить это поле?';
     $this->LANG['confcomp']['master_2_remove_title_note'] = 'Удаление поля приведет к потери данных в нем.';
     
     $this->LANG['confcomp']['master_2_name'] = 'Название поля';
     $this->LANG['confcomp']['master_2_ind'] = 'Индификатор поля';
     $this->LANG['confcomp']['master_2_main'] = 'Значение в списке';
     $this->LANG['confcomp']['master_2_main_error'] = 'В конфигураторе не указанно ни одного поля для отображения в списке';
     $this->LANG['confcomp']['master_2_des'] = 'Описание';
     $this->LANG['confcomp']['master_2_ind_note'] = 'Индификатор должн содержать только латинские символы и цифры, значение должно быть уникаьлным';
     
     $this->LANG['confcomp']['master_2_type'] = 'Тип поля';
     $this->LANG['confcomp']['master_2_type_note'] = 'Изменение типа поля может повлечь к потере данных в этом поле';
     
     $this->LANG['confcomp']['types']['varchar'] = 'Строка';
     $this->LANG['confcomp']['types']['memo'] = 'Текст';
     $this->LANG['confcomp']['types']['int'] = 'Целое число';
     $this->LANG['confcomp']['types']['float'] = 'Число с плавающей точкой';
     $this->LANG['confcomp']['types']['date'] = 'Дата';
     $this->LANG['confcomp']['types']['time'] = 'Время';
     $this->LANG['confcomp']['types']['datetime'] = 'Дата + Время';
     $this->LANG['confcomp']['types']['file'] = 'Файл (путь до файла)';
     $this->LANG['confcomp']['types']['list'] = 'Список';
     $this->LANG['confcomp']['types']['bool'] = 'Логическое поле (Истина / Лож)';
     //$this->LANG['confcomp']['types']['imglist'] = 'Фото—галерея объекта';
     
     
     $this->LANG['confcomp']['format']['varchar']['0'] = 'Максимальная длинна строки';
     $this->LANG['confcomp']['format']['varchar_error']['0'] = 'Вы привысили максимальную длинну строки'; 
     
     $this->LANG['confcomp']['format']['memo']['0'] = 'Подключить редактор';
     
     $this->LANG['confcomp']['format']['int']['0'] = 'Максимальная длинна строки';
     $this->LANG['confcomp']['format']['int_error']['0'] = 'Вы привысили максимальную длинну строки';
     $this->LANG['confcomp']['format']['int']['1'] = 'Минимальное значение';
     $this->LANG['confcomp']['format']['int_error']['1'] = 'Число меньше минимального значения';
     $this->LANG['confcomp']['format']['int']['2'] = 'Максимальное значение';
     $this->LANG['confcomp']['format']['int_error']['2'] = 'Вы привысили максимальное значение';
     $this->LANG['confcomp']['format']['int_error']['3'] = 'Значение не является числом';
    	
     $this->LANG['confcomp']['format']['float']['0'] = 'Максимальная длинна строки';
     $this->LANG['confcomp']['format']['float']['1'] = 'Минимальное значение';
     $this->LANG['confcomp']['format']['float']['2'] = 'Максимальное значение';
     $this->LANG['confcomp']['format']['float']['3'] = 'Кол-во символов после запятой(точки)';
     
    
     $this->LANG['confcomp']['format']['date']['0'] = 'Подставлть текущую дату';	
     $this->LANG['confcomp']['format']['time']['0'] = 'Подставлть текущее время';
     $this->LANG['confcomp']['format']['datetime']['0'] = 'Подставлть текущую дату и время';
     
     $this->LANG['confcomp']['format']['file']['0'] = 'Домустимые форматы файлов (через запятую, например jpg,png,gif или * для всех)';
     
     $this->LANG['confcomp']['def'] = 'По умолчанию';
     
     $this->LANG['confcomp']['format']['list']['0'] = 'Список элементов (элемент на каждую строку, значение:надпись)';
    	
    
     $this->LANG['confcomp']['format']['imglist']['0'] = 'Ширина превью';
     $this->LANG['confcomp']['format']['imglist']['1'] = 'Высота превью';
     $this->LANG['confcomp']['format']['imglist']['2'] = 'Ширина оригинала';
     $this->LANG['confcomp']['format']['imglist']['3'] = 'Высота оригинала';     
     
     
     $this->LANG['confcomp']['master_3_nofields'] = 'Список шаблонов пуст';
     $this->LANG['confcomp']['master_3_new'] = 'Создать новый шаблон';
     $this->LANG['confcomp']['master_3_edit'] = 'Редактировать шаблон — ';
     $this->LANG['confcomp']['master_3_setting'] = 'Настройки шаблона — ';
     $this->LANG['confcomp']['master_3_remove'] = 'Удалить шаблон — ';
     $this->LANG['confcomp']['master_3_remove_title'] = 'Вы действительно хотите удалить этот шаблон?';
     $this->LANG['confcomp']['master_3_remove_title_note'] = 'Удаление шаблона приведет к потери формирования контента привязанного к нему раздела.';
     
     $this->LANG['confcomp']['master_3_name'] = 'Название шаблона';
     $this->LANG['confcomp']['master_3_name_note'] = 'Название шаблона должно содержать только латинские символы и цифры, значение должно быть уникаьлным';
     $this->LANG['confcomp']['master_3_des'] = 'Описание';
     
     
     $this->LANG['confcomp']['master_3_file_list'] = 'Объект в списке';
     $this->LANG['confcomp']['master_3_file_one'] = 'Просмотр объекта';
     $this->LANG['confcomp']['master_3_file_cssjs'] = 'CSS и javaScript';
     $this->LANG['confcomp']['master_3_file_kernel'] = 'Добавить / Редактировать';
     
     $this->LANG['confcomp']['master_3_file_sufix']='Суфикс';
     $this->LANG['confcomp']['master_3_file_prefix']='Префикс';
     $this->LANG['confcomp']['master_3_file_content']='Объект';
     $this->LANG['confcomp']['master_3_file_sql']='SQL';
     $this->LANG['confcomp']['master_3_file_admin_sql']='административный SQL';
     $this->LANG['confcomp']['master_3_file_admin_sql_error']='SQL ошибка в шаблоне';
     
    
     
     $this->LANG['confcomp']['master_3_file_css']='CSS';
     $this->LANG['confcomp']['master_3_file_js']='javaScript'; 
     
     $this->LANG['confcomp']['master_3_file_after']='После выполнения';
     $this->LANG['confcomp']['master_3_file_before']='Перед выполнением';
     
     
     $this->LANG['confcomp']['comp_not_found'] = 'Компонент не найден';	
     $this->LANG['confcomp']['field_not_found'] = 'Поле не найдено';
     $this->LANG['confcomp']['tpl_not_found'] = 'Шаблон не найден';
     
     
     $this->LANG['confcomp']['master_4_go'] = 'Для экспорта нажмите «Далее»';
     
     $this->LANG['confcomp']['editpage_c'] = 'Компонент'; 
     $this->LANG['confcomp']['editpage_add'] = 'Добавить запись';
     $this->LANG['confcomp']['editpage_list'] = 'Список';
     $this->LANG['confcomp']['editpage_show'] = 'запись публикуется';
     $this->LANG['confcomp']['editpage_saveandgo'] = 'и перейти к списку';
     $this->LANG['confcomp']['editpage_saveandgoback'] = 'и вернуться';
     
     $this->LANG['confcomp']['editpage_repage'] = 'Вы действительно хотите перенести объект в другой раздел?';
     
     $this->LANG['configurationcomponent']['access'] = 'Доступ к конфигуратору компонентов';
     
     $this->LANG['confcomp']['editpage']['imglist']['upload'] = 'Загрузить новые фотографии';
 
 
?>
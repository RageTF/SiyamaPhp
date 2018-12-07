<?

/**
 * @author Maltsev Vladimir
 * @copyright 2009
 * 
 */

  $help['index']='
  
  
  <li>Если у Вас есть необходимость создать компонент «налету», то Вы можете это сделать в данном разделе.</li>
  
  
  ';
  
  $help['master:0']=' <li>Конфигуратор компонентов работает по принципу связки сформированной таблицы в БД с шаблонами вывода информации из нее.</li>';  
  $help['master:1']=' <li>Для удобной ориентации среди компонентов введите описание, и загрузите иконку, или пропустите этот шаг.</li>';
  $help['master:2']=' <li>Каждый компонент имеет свою таблицу в БД с набором полей. Значение каждого поля присваивается к переменной <strong>$row</strong> с индексом индификатора этого поля. Так же к каждому полю присваивается <strong>своя форма</strong> для внедрения объекта в БД.</li> <li>Для изменения порядка вывода форм -  нажмите и перетащите строку с названием поля</li>';  
  $help['master:2:0']=' <li>Каждый компонент имеет свою таблицу в БД с набором полей. Значение каждого поля присваивается к переменной <strong>$row</strong> с индексом индификатора этого поля. Так же к каждому полю присваивается <strong>своя форма</strong> для внедрения объекта в БД.</li><li>Укажите тип поля для формирования формы.</li><li>Параметр «Значение в списке» служит для удобной ориентации среди записей.</li>';  
  $help['master:2:1']=' <li>Теперь Вы можете настроить параметры поля.</li>';  
  
  $help['master:3']=' <li>Каждый компонент имеет набор шаблонов для вывода информации из своей таблицы в БД.</li>';
  $help['master:3:1']=' <li>Конфигуратор генерирует два режима вывода информации – <strong>список объектов</strong>, <strong>просмотр объекта</strong> (например: список новостей, просмотр одной новости)</li>
  <li>Каждый режим имеет структуру: <strong>префикс</strong> (перед выводом списка или объекта),  <strong>объект</strong> (непосредственно отвечает за вывод данных из таблицы компонента), <strong>суффикс</strong> (после вывода списка или объекта).</li>
<li>В поле «<strong>объект</strong>» создается оформление данных компонента. Значение каждого поля присваивается к переменной $row с индексом индификатора этого поля.</li>
';
     


?>
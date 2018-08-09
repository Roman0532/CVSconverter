# CVSconverter

## Программа предназначенна для конвертирования входного cvs файла в другой выходной csv файл по заданным в конфиг файле условиям

## Что бы использовать консольную программу, на рабочей машине нужно установить следующее ПО

PHP 7 <br>
Composer <br>

## Для запуска проекта необходимо:
<ul>
  <li>Склонировать проект на локальную машину используя команду git clone https://github.com/Roman0532/CVSconverter.git</li>
  
  <li>Перейти в папку с проектом и выполнить команду composer install</li>
</ul> 
  
## Для запуска программы необходимо в консоли ввести команду php index.php [options];

### Cуществуют следующие [options] :
  
-i|--input file - путь до исходного файла
  
-c|--config file - путь до файла конфигурации

-o|--output file - путь до файла с результатом

-d|--delimiter delim - задать разделитель (по умолчанию “,”)

--skip-first - пропускать модификацию первой строки исходного csv

--strict - проверять, что исходный файл содержит необходимое количество описанных в конфигурационном файле столбцов. При несоответствии выдавать ошибку.

-h|--help - вывести справку
 
 </ul>

## Для запуска bash тестов необходимо

<ul>
  <li>Перейти в папку Tests/BashTest</li>
  <li>Выдать права на исполнение всем bash скриптам выполнив комманды sudo chmod +x <FILE></li>
  <li>Набрать команду в консоли ./TEST.sh для запуска общих тестов либо ./MYPROJECTTEST для запуска тестов конкретно для проекта</li>
</ul> 

## Для запуска unit тестов необходимо

<ul>
  <li>Перейти в папку Tests/UnitTest</li>
  <li>Выполнить команду ../../vendor/bin/phpunit .</li>
</ul> 

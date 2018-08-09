#!/usr/bin/env bash
# Счетчик тестов которые не прошли
errors=0
# Счетчик тестов которые прошли
passed=0

INFILE='../testInput.csv'
OUTFILE='../testOutput.csv'
CONFILE='../testConf.php'
TEST_OUTPUT_FILE='../testOutput1.csv'

././RUN.sh "-i $INFILE -o $OUTFILE -c $CONFILE"

if [ ! -e "$INFILE" ]; then
    echo "FAILED Файл $INFILE не существует"
     ((errors++))
     else
       echo "PASSED Файл $INFILE существует"
       ((passed++))
fi

if [ ! -r "$INFILE" ]; then
    echo "FAILED Файл $INFILE не доступен для чтения"
     ((errors++))
     else
    echo "PASSED Файл $INFILE доступен для чтения"
       ((passed++))
fi

if [ ! -e "$OUTFILE" ]; then
    echo "FAILED Файл $OUTFILE не существует"
     ((errors++))
     else
     echo "PASSED Файл $OUTFILE существует"
       ((passed++))
fi

if [ ! -w "$OUTFILE" ]; then
    echo "FAILED Файл $OUTFILE не доступен для записи"
     ((errors++))
     else
     echo "PASSED Файл $OUTFILE доступен для записи"
       ((passed++))
fi

if [ ! -e "$CONFILE" ]; then
    echo "FAILED Файл $CONFILE не существует"
     ((errors++))
     else
      echo "PASSED Файл $CONFILE существует"
       ((passed++))
fi

if [ ! -r "$CONFILE" ]; then
    echo "FAILED Файл $CONFILE не доступен для чтения"
     ((errors++))
     else
      echo "PASSED Файл $CONFILE доступен для чтения"
       ((passed++))
fi

if [ $(cat "$OUTFILE" | wc -l) -eq $(cat "$TEST_OUTPUT_FILE" | wc -l) ]; then
    echo "PASSED Количество строк в файлах совпадает"
     ((passed++))
     else
     echo "FAILED Количество строк в файлах не совпадает"
      ((errors++))
fi

if cmp -s "$OUTFILE" "$TEST_OUTPUT_FILE"; then
 echo "PASSED Файлы соотвествуют друг другу"
   ((passed++))
 else  echo "FAILED файлы не соотвествуют друг другу"
 ((errors++))
fi

echo
echo $errors test not passed
echo $passed test passed
#  количество не пройденых тестов больше 0 возвращать код 1
if [[ $errors -gt 0 ]]; then
    exit 1
fi
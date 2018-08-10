#!/usr/bin/env bash
# Счетчик тестов которые не прошли
errors=0
# Счетчик тестов которые прошли
passed=0
# Общий счетчик количества тестов
count=0
check() {
 ./RUN.sh $1
  result=$?
  ((count++))
# Если полученый код после вызова RUN.sh равен желаемому
# увеличиваем количество пройденых тестов
    if [[ $result -eq $2 ]]; then
       ((passed++))
       echo $count  PASSED $1 "'$2'" $result
# Иначе увеличиваем количество не пройденых
    else
       ((errors++))
       echo $count FAILED $1  "'$2'" $result
    fi
}

INFILE='../testInput.csv'
OUTFILE='../testOutput.csv'
CONFILE='../testConf.php'

check "" 1

check "-h" 0

check "-i $INFILE -o $OUTFILE -c $CONFILE" 0

check "-i $INFILE -o $OUTFILE -c $CONFILE -d ," 0
check "-i $INFILE -o $OUTFILE -c $CONFILE -s" 0

check "-i $INFILE" 1
check "-o $OUTFILE" 1
check "-i $INFILE -o ../output.csv1 -c $CONFILE" 244
check "-i $INFILE -o $OUTFILE -c ../conf.php1" 244

echo
echo $errors test not passed
echo $passed test passed
#  количество не пройденых тестов больше 0 возвращать код 1
if [[ $errors -gt 0 ]]; then
    exit 1
fi

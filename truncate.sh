#/bin/bash

db_host=
db_user=
db_pwd=
db_arr=()

# mysql
truncate(){
    mysql -h${db_host} -u${db_user} -p${db_pwd} --database ${1} -e "truncate table ${2}"
}


for db in ${dbarr}
do
	tables=($(mysql -h${db_host} -u${db_user} -p${db_pwd} --database ${db} -e "show tables"))
 	num=${#tables[*]}
	for ((i=0; i<=${num}; i++))
	do
		if [ ${i} -eq 0 -o ${i} -eq ${num} ];then
			continue;
		fi
		truncate ${db} ${tables[i]}
	done
echo ${db}"清空完毕"
done

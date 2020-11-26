#!/bin/bash

cmd="nc -w 60 -q 10 localhost 30002 | nc -w 60 -q 10 data.adsbhub.org 5001"
#cmd="nc -w 60 -q 10 localhost 30002 | nc -w 60 -q 10 94.130.23.233 5001"

while true; do
    check=`netstat -a | grep "adsbhub[.]org[.]5001 \|adsbhub[.]org:5001 \|data[.]adsbhub[.]org[.]5001 \|data[.]adsbhub[.]org:5001 "`
    #check=`netstat -an | grep "94[.]130[.]23[.]233[.]5001 \|94[.]130[.]23[.]233:5001 "`

    if [ ${#check} -ge 10 ]
    then
	result="connected"
    else
	result="not connected"
	eval "${cmd}" &
    fi

    #echo $result

    sleep 60
done

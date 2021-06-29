
key='6d61737465725f6b65795f4954414348493a323032312d30362d3330'
path='/srv/http/clinic.loc'
sn=`udevadm info --query=all --name=/dev/sda | grep ID_SERIAL_SHORT | sed "s/E: ID_SERIAL_SHORT=/${replace}/"`

if [ $sn ] 
then

   comm=`php7 $path/box key:$key $sn`
   if [ $comm == "---DONE---" ]
   then
      echo "[security] Done"
   else
      echo "[security] Fail"
      rm $path/.key
   fi

else
   echo "[security] Fail"
   rm $path/.key
fi
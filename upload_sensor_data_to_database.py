import mysql.connector
from mysql.connector import Error
from mysql.connector import errorcode
import datetime
import Adafruit_DHT
import time

#Get data from sensor and return temperature and humidity
def get_sensor_data(sensor,pin):
    import Adafruit_DHT

    hum, temp = Adafruit_DHT.read_retry(sensor, pin)

    if hum is not None and temp is not None:
        if pin == 4:
            print("Sensor 1 : Temp={0:0.1f}*C  Humidity={1:0.1f}%".format(temp, hum))
        elif pin == 10:
            print("Sensor 2 : Temp={0:0.1f}*C  Humidity={1:0.1f}%".format(temp, hum))
        print('pass')
    else:
        print("Failed to retrieve data from humidity sensor")

    return temp,hum

#Connect to MySQL database and insert temperature, humidity and time
def connect(database_name,time, temp, hum):
    """ Connect to MySQL database """
    conn = None
    try:
        conn = mysql.connector.connect(host='johnny.heliohost.org',
                                       database='nhep_test',
                                       user='nhep_test',
                                       password='Wyf1wyawy')
        if conn.is_connected():
            print('Connected to MySQL database')

    except Error as err:
        if err.errno == errorcode.ER_ACCESS_DENIED_ERROR:
            print("Something is wrong with your user name or password")
        elif err.errno == errorcode.ER_BAD_DB_ERROR:
            print("Database does not exist")
        else:
            print(err)

    mycursor = conn.cursor()

    sql = "INSERT INTO " +database_name+ " (time, temp, hum) VALUES (%s, %s, %s)"
    val = (time, temp, hum)
    mycursor.execute(sql, val)

    conn.commit()

    print(mycursor.rowcount, "record inserted.")

    mycursor.close()
    conn.close()


if __name__ == '__main__':
    #config DHT22 sensors
    sensor= Adafruit_DHT.DHT22
    pin1 = 4
    pin2 = 10
    while True:
        get_time = datetime.datetime.now()
        formatted_time = get_time.strftime('%Y-%m-%d %H:%M:%S')
        temp, hum = get_sensor_data(sensor,pin1)
        #MySQL
        connect("Sensor1",formatted_time,temp,hum)
        temp, hum = get_sensor_data(sensor,pin2)
        connect("Sensor2",formatted_time,temp,hum)
        time.sleep(3600)

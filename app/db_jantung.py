import mysql.connector
import time
import random

def generate_heart_data():
    DetakJantung = random.randint(60, 80)
    SaturasiOksigen = random.randint(95, 100)
    return DetakJantung, SaturasiOksigen

def connect_to_db():
    try:
        return mysql.connector.connect(
            host="localhost",
            user="root",      
            password="",      
            database="medis"
        )
    except mysql.connector.Error as err:
        print(f"Error connecting to database: {err}")
        exit(1)

def send_data_to_db(cursor, id_pasien, id_jantung, DetakJantung, SaturasiOksigen):
    sql = "INSERT INTO db_jantung (id_pasien, id_jantung, DetakJantung, SaturasiOksigen, Waktu) VALUES (%s, %s, %s, %s, NOW())"
    val = (id_pasien, id_jantung, DetakJantung, SaturasiOksigen)
    try:
        cursor.execute(sql, val)
    except mysql.connector.Error as err:
        print(f"Error: {err}")

def main():
    db = connect_to_db()
    cursor = db.cursor()
    id_pasien = 1
    id_jantung = 5
    try:
        while True:
            DetakJantung, SaturasiOksigen = generate_heart_data()
            send_data_to_db(cursor, id_pasien, id_jantung, DetakJantung, SaturasiOksigen)
            db.commit()
            print(f"Data terkirim: id_pasien = {id_pasien}, id_jantung = {id_jantung}, Detak Jantung = {DetakJantung}, Saturasi Oksigen = {SaturasiOksigen}")
            id_jantung += 1
            time.sleep(5)  

    except KeyboardInterrupt:
        print("----------------Program dihentikan.-------------")
    finally:
        cursor.close()
        db.close()

if __name__ == "__main__":
    main()

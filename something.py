import RPi.GPIO as GPIO
import time, datetime

now = datetime.datetime.now()
low_pin = 4
medium_pin = 5
high_pin = 22
green_led = 18
yellow_led = 27
red_led = 24
switchA = 19

GPIO.setmode(GPIO.BCM)
GPIO.setup(low_pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.input(low_pin)
GPIO.setup(medium_pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.input(medium_pin)
GPIO.setup(high_pin, GPIO.IN, pull_up_down=GPIO.PUD_DOWN)
GPIO.input(high_pin)
GPIO.setwarnings(False)
GPIO.setup(green_led, GPIO.OUT)
GPIO.output(green_led, GPIO.HIGH)
GPIO.setup(yellow_led, GPIO.OUT)
GPIO.output(yellow_led, GPIO.HIGH)
GPIO.setup(red_led, GPIO.OUT)
GPIO.output(red_led, GPIO.HIGH)
GPIO.setup(switchA, GPIO.IN)


def onSwitch(channel):
    storage = open("waterlevel.txt", "a+")
    if (channel == low_pin):
        storage.writelines("{\"level\":\"low\", " + "\"time\": \"" + now.strftime("%Y-%m-%d %H:%M") + "\"}\n")
        GPIO.output(red_led, GPIO.LOW)
        GPIO.output(yellow_led, GPIO.LOW)
        GPIO.output(green_led, GPIO.LOW)
    elif (channel == medium_pin):
        storage.writelines("{\"level\":\"medium\", " + "\"time\": \"" + now.strftime("%Y-%m-%d %H:%M") + "\"}\n")
        GPIO.output(yellow_led, GPIO.LOW)
        GPIO.output(green_led, GPIO.LOW)
        GPIO.output(red_led, GPIO.HIGH)
    elif (channel == high_pin):
        storage.writelines("{\"level\":\"high\", " + "\"time\": \"" + now.strftime("%Y-%m-%d %H:%M") + "\"}\n")
        GPIO.output(green_led, GPIO.LOW)
        GPIO.output(yellow_led, GPIO.HIGH)
        GPIO.output(red_led, GPIO.HIGH)


while True:
    if not 'event' in locals():
        event = GPIO.add_event_detect(low_pin, GPIO.RISING, callback=onSwitch, bouncetime=200)
        event = GPIO.add_event_detect(medium_pin, GPIO.RISING, callback=onSwitch, bouncetime=200)
        event = GPIO.add_event_detect(high_pin, GPIO.RISING, callback=onSwitch, bouncetime=200)
    else:
        if GPIO.input(switchA) != 0:
            while True:
                GPIO.output(green_led, GPIO.HIGH)
                GPIO.output(yellow_led, GPIO.HIGH)
                GPIO.output(red_led, GPIO.HIGH)
                break

storage.close()
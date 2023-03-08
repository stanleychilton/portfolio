#include "mbed.h"
#include "uart.h"
#include "stepper.h"
#include <string>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#define LCD_DATA 1
#define LCD_INSTRUCTION 0

DigitalOut greenLed(PA_5);
DigitalOut Blueled(PA_7);
Uart uart(PA_2, PA_3);
int blueledtog = 0;
int greenledtog = 0;
int sensortog = 0;
int direction = 1;
int delay = 10; 
Ticker t;
void lcdCommand(unsigned char command);
void lcdPutChar(unsigned char c);
void lcdPutString(char *s);
static void lcdSetRS(int mode); //-- mode is either LCD_DATA or LCD_INSTRUCTION
static void lcdPulseEN(void);
static void lcdInit8Bit(unsigned char command);
DigitalOut lcdD4(PA_9), lcdD5(PA_8), lcdD6(PB_10), lcdD7(PB_4);
DigitalOut lcdEN(PC_7), lcdRS(PB_6);
PwmOut usTrig(PB_3);
DigitalIn usEcho(PB_5);
PwmOut servo(PB_0);
//Timer t;

int main()
{
    Stepper myStepper(PC_0, PC_1, PC_2, PC_3, 10);
    while (1) {
        if(uart.isDataReady()){
            char input = uart.getChar();
            uart.putChar(input);
            if(input == 'B'){
                if(blueledtog == 0){ //blue led working
                    blueledtog = 1;
                }else{
                    blueledtog = 0;
                }
                Blueled.write(blueledtog);
                }
            else if(input == 'G'){  //green led working
                if(greenledtog == 0){
                    greenledtog = 1;
                }else{
                    greenledtog = 0;
                }
                greenLed.write(greenledtog);
                }
            else if(input == 'S'){  //toggle stepper working
                myStepper.toggleOn();
            }
            else if(input == 'T'){  //toggle stepper direction working
                myStepper.toggleDirection();
            }
            else if(input == 'D'){       // toggle delay working
                int num1 = uart.getChar()-'0'; //only works if the stepper is started again though
                int num2 = uart.getChar()-'0';
                int num3 = (num1*10)+num2;
                myStepper.setDelay(num3);
            }else if(input == 'M'){
                lcdEN.write(0); //-- GPIO_WriteBit(GPIOC, LCD_EN, Bit_RESET);
                wait_us(15000); //-- delay for >15msec second after power on
                lcdInit8Bit(0x30); //-- we are in "8bit" mode
                wait_us(4100); //-- 4.1msec delay
                lcdInit8Bit(0x30); //-- but the bottom 4 bits are ignored
                wait_us(100); //-- 100usec delay
                lcdInit8Bit(0x30);
                lcdInit8Bit(0x20);
                lcdCommand(0x28); //-- we are now in 4bit mode, dual line
                lcdCommand(0x08); //-- display off
                lcdCommand(0x01); //-- display clear
                wait_us(2000); //-- needs a 2msec delay !!
                lcdCommand(0x06); //-- cursor increments
                lcdCommand(0x0f); //-- display on, cursor(blinks) on
                char s[80];
                while(uart.canReadLine()){
                    uart.readLine(s);
                    s[strlen(s)-1] = '\0';
                    uart.writeLine(s);
                }
                lcdPutString(s);
//            }else if(input == 'U'){
//                if(sensortog == 0){
//                    t.start();
//                    sensortog = 1;
//                }else{
//                    t.stop();
//                    sensortog = 0;
//                }
//                
            }else if(input == 'A'){
                int num1 = uart.getChar()-'0';
                int num2 = uart.getChar()-'0';
                int angle = (num1*10)+num2;
                int number = ((1000/90)*angle)+1000;
                  servo.pulsewidth_us(number); //-- pulse width of 1 ms; 0 degrees
            }
        }
    }
}


static void lcdSetRS(int mode){
     lcdRS.write(mode);
}
static void lcdPulseEN(void){
     lcdEN.write(1);
     wait_us(1); //-- enable pulse must be >450ns
     lcdEN.write(0);
     wait_us(1);
}
static void lcdInit8Bit(unsigned char command){
     lcdSetRS(LCD_INSTRUCTION);
     lcdD4.write((command>>4) & 0x01); //-- bottom 4 bits
     lcdD5.write((command>>5) & 0x01); //-- are ignored
     lcdD6.write((command>>6) & 0x01);
     lcdD7.write((command>>7) & 0x01);
     lcdPulseEN();
     wait_us(37); //-- let it work on the data
}

void lcdCommand(unsigned char command)
{
     lcdSetRS(LCD_INSTRUCTION);
     lcdD4.write((command>>4) & 0x01);
     lcdD5.write((command>>5) & 0x01);
     lcdD6.write((command>>6) & 0x01);
     lcdD7.write((command>>7) & 0x01);
     lcdPulseEN(); //-- this can't be too slow or it will time out
     lcdD4.write(command & 0x01);
     lcdD5.write((command>>1) & 0x01);
     lcdD6.write((command>>2) & 0x01);
     lcdD7.write((command>>3) & 0x01);
     lcdPulseEN();
     wait_us(37); //-- let it work on the data
}

void lcdPutChar(unsigned char c){
     lcdSetRS(LCD_DATA);
     lcdD4.write((c>>4) & 0x01);
     lcdD5.write((c>>5) & 0x01);
     lcdD6.write((c>>6) & 0x01);
     lcdD7.write((c>>7) & 0x01);
     lcdPulseEN(); //-- this can't be too slow or it will time out
     lcdD4.write(c & 0x01);
     lcdD5.write((c>>1) & 0x01);
     lcdD6.write((c>>2) & 0x01);
     lcdD7.write((c>>3) & 0x01);
     lcdPulseEN();
     wait_us(37); //-- let it work on the data
}


void lcdPutString(char *word){
    int count = 0;
    while(*(word+count)){
        lcdPutChar(*(word+count));
        count++;
        }
}

//void sensor()
//{
//     float pulseWidth; //-- pulse width in uSec
//     float distance; //-- distance in CM
//    
//     usTrig.period_us(100000);
//     usTrig.pulsewidth_us(10);
//     printf("Ultrasonic Sensor:\n");
//     while(1)
//     {
//         //-- wait for Echo signal to go high
//         while (! usEcho.read()); t.start();
//         //-- wait for Echo signal to go low
//         while (usEcho.read());
//         t.stop();
//        
//         //printf("%d\n", t.read_us());
//         pulseWidth = t.read_us();
//         distance = (float)0.017*pulseWidth;
//         printf("Distance [CM]: %5.2f", distance);
//         printf("\n");
//         t.reset();
//         wait(1); //-- wait 1 second
//     }
//}
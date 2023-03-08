//-- LCD Program
#include "mbed.h"
#include <stdlib.h>
#include <stdio.h>
#include <iostream>
#include <string>
#define LCD_DATA 1
#define LCD_INSTRUCTION 0
DigitalIn button(PC_13);
void lcdCommand(unsigned char command);
void lcdPutChar(unsigned char c);
void lcdPutString(char *s);
void customTimer(int s);
void binarycalc();
void decimalcalc();
void hexcalc();
static void lcdSetRS(int mode); //-- mode is either LCD_DATA or LCD_INSTRUCTION
static void lcdPulseEN(void);
static void lcdInit8Bit(unsigned char command);
//-- the first few commands of initialisation, are still in pseudo 8-bit data mode
DigitalOut lcdD4(PA_9), lcdD5(PA_8), lcdD6(PB_10), lcdD7(PB_4);
DigitalOut lcdEN(PC_7), lcdRS(PB_6);
int menu_item = 1;

int main(){
     while(1){
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
     if (menu_item == 1){
         lcdCommand(0x01);
         wait_us(2000);
         lcdPutString("binary");
         customTimer(1);
         menu_item++;
     }else if(menu_item == 2){
         lcdCommand(0x01);
         wait_us(2000);
         lcdPutString("decimal");
         customTimer(2);
         menu_item++;
     }else if(menu_item == 3){
         lcdCommand(0x01);
         wait_us(2000);
         lcdPutString("hexidecimal");
         customTimer(3);
         menu_item = 1;
        }
    }
}
 
void customTimer(int n){
    for(int i = 0; i < 25000000; i++){
        if(button.read() == 0){
            if (n == 1){
                binarycalc();
            }else if(n == 2){
                decimalcalc();
            }else if(n == 3){
                hexcalc();
            }
        }
    }
}   

void binarycalc(){
    int number = 0;
    int control = 0;
    while (number != 16){
        if(button.read() == 1 and control == 0){
            number++;
            control++;
            std::string numstring;
            int calcnum = number;
            int count = 8;
            while (count != 0){
                if (calcnum/count==1){
                    numstring.append("1");
                    calcnum -= count;
                }else{
                    numstring.append("0");
                    }  
                count = count/2;
                }
            lcdCommand(0x01);
            wait_us(2000);
            lcdPutString((char *)numstring.data());
            wait_us(2000);
            
        }else if(control == 1 and button.read() == 0){
            control = 0;
        }
    }
    menu_item = 2;
    main();
}

void decimalcalc(){
    int number = 0;
    int control = 0;
    char numstring[10];
    while (number != 16){
        if(button.read() == 1 and control == 0){
            number++;
            control = 1;
            lcdCommand(0x01);
            wait_us(2000);
            sprintf(numstring, "%d", number);
            lcdPutString(numstring);
            wait_us(2000);
            }
        else if(control == 1 and button.read() == 0){
            control = 0;
        }
    }
    menu_item = 3;
    main();
}

void hexcalc(){
    int number = 0;
    int control = 0;
    char numstring[10];
    while (number != 16){
        if(button.read() == 1 and control == 0){
            number++;
            control = 1;
            lcdCommand(0x01);
            wait_us(2000);
            sprintf(numstring, "%x", number);
            lcdPutString(numstring);
            wait_us(2000);
            }
        else if(control == 1 and button.read() == 0){
            control = 0;
        }
    }
    menu_item = 1;
    main();
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



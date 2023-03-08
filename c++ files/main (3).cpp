#include "mbed.h"

DigitalOut greenled(PA_5);
DigitalOut blueled(PA_7);
int greenledtimer = 3;
int blueledtimer = 4;
int scale = greenledtimer * blueledtimer;
int num;

int main() {
    while(1) {
        num += 1;
        if ( num % greenledtimer == 0 ){
            blueled = 1; // LED is ON
        }
        if ( num % blueledtimer == 0 ){
            greenled = 1; // LED is ON
        }
        if(num == scale){
            num = 0;
            }
        wait(1);
        greenled = 0;
        blueled = 0;
    }
}
#include "mbed.h"

void led();

DigitalOut GreenLED(PA_5);
DigitalOut blueLED(PA_7);

int main() {
    while(1) {
    }
}

void ledon(){
    GreenLED = 1; // LED is ON
    blueLED = 1; // LED is on
    }
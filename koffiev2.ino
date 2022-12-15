// Weegschaal
#include "HX711.h"
HX711 scale;
uint8_t dataPin = D2;  // wemos uses D instead of A
uint8_t clockPin = D3;
// einde weegschaal

// wifi
#include <Arduino.h>
#include <ESP8266WiFi.h>
#include <ESP8266WiFiMulti.h>
#include <ESP8266HTTPClient.h>
#define USE_SERIAL Serial
ESP8266WiFiMulti WiFiMulti;
// einde wifi

void setup() {
  Serial.begin(115200);
  // USE_SERIAL.setDebugOutput(true);

  // eerst de wifi

  for (uint8_t t = 4; t > 0; t--) {
    USE_SERIAL.printf("[SETUP] WAIT %d...\n", t);
    USE_SERIAL.flush();
    delay(1000);
  }

  WiFi.mode(WIFI_STA);
  WiFiMulti.addAP("Valtech Guest", "2022ValGue");

  // Dan de weegschaal. Welke hx711 versie?
  Serial.println(__FILE__);
  Serial.print("LIBRARY VERSION: ");
  Serial.println(HX711_LIB_VERSION);
  Serial.println();
  // Setup weegschaal
  scale.begin(dataPin, clockPin);

  Serial.print("UNITS: ");
  Serial.println(scale.get_units(10));

  Serial.println("\nEmpty the scale, press a key to continue");
  while (!Serial.available())
    ;
  while (Serial.available()) Serial.read();

  scale.tare();
  Serial.print("UNITS: ");
  Serial.println(scale.get_units(10));


  Serial.println("\nPut 1000 gram in the scale, press a key to continue");
  while (!Serial.available())
    ;
  while (Serial.available()) Serial.read();

  scale.calibrate_scale(1000, 5);
  Serial.print("UNITS: ");
  Serial.println(scale.get_units(10));

  Serial.println("\nScale is calibrated, press a key to continue");
  // Serial.println(scale.get_scale());
  // Serial.println(scale.get_offset());
  while (!Serial.available())
    ;
  while (Serial.available()) Serial.read();
}


void loop() {
  // printen van het gewicht 
  Serial.print("UNITS: ");
  float weight = scale.get_units(10);
  String str = String(weight);  // float to string

  Serial.println(str);
  
  // aanroepen URL
  if ((WiFiMulti.run() == WL_CONNECTED)) {

    HTTPClient http;

    USE_SERIAL.print("[HTTP] begin...\n");
    //http.begin("http://www.erikvanzuijdam.nl/altijdkoffie/store.php?gewicht=")Gewicht"&key=DikkeDoei"); //HTTP

    String url = "http://www.erikvanzuijdam.nl/altijdkoffie/store.php?gewicht=" + str + "&key=DikkeDoei";
    http.begin(url);

    USE_SERIAL.print("[HTTP] GET...\n");
    // start connection and send HTTP header
    int httpCode = http.GET();

    // httpCode will be negative on error
    if (httpCode > 0) {
      // HTTP header has been send and Server response header has been handled
      USE_SERIAL.printf("[HTTP] GET... code: %d\n", httpCode);

      // file found at server
      if (httpCode == HTTP_CODE_OK) {
        String payload = http.getString();
        USE_SERIAL.println(payload);
      }
    } else {
      USE_SERIAL.printf("[HTTP] GET... failed, error: %s\n", http.errorToString(httpCode).c_str());
    }

    http.end();
  }
  
  
  delay(5000);
}


// -- END OF FILE --

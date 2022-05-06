
#include <Servo.h>
#include <LiquidCrystal_I2C.h>
#include "FirebaseESP8266.h"
#include <ESP8266WiFi.h>
//#define servoPin 8
#define servoPin1 D7
#define isGarbage A0
#define isWet D3
#define trigPin D6 //Define the Trigger pin of the Ultrasonic
#define echoPin1 D5 //Define the Echo pin of the Ultrasonic
#define echoPin2 D8

//------------------
#define FIREBASE_HOST "https://smartbin-9d2b7-default-rtdb.firebaseio.com/"
#define FIREBASE_AUTH "uENHOiY4nDfIpd1FZoR6LL9OQ7pziLI1Cb1zq8oi"
#define WIFI_SSID "Project2022"//"OnePlus6"
#define WIFI_PASSWORD "okgoogle"//"12345678"

//Define FirebaseESP8266 data object
FirebaseData firebaseData;
FirebaseJson json;
void printResult(FirebaseData &data);

String DataPathDry = "/BinIds/123/Dry";
String DataPathWet = "/BinIds/123/Wet";
//------------------
Servo S1;  // create servo object to control a servo
int ReadyPos=90;
int DryPos=160;
int WetPos=20;
int angle = 90;
char incoming_char = 0;

int lcdColumns = 16;
int lcdRows = 2;
LiquidCrystal_I2C lcd(0x27, lcdColumns, lcdRows);
 
int ultrasonic(int a)
{
  int duration, distance;
  digitalWrite(trigPin, HIGH); //Write High for 1ms
  delayMicroseconds(1000);// 1  mili sec
  digitalWrite(trigPin, LOW);

  switch (a)
  {
    case 1:
      duration = pulseIn(echoPin1, HIGH); //Time pulse in
      break;
    case 2:
      duration = pulseIn(echoPin2, HIGH); //Time pulse in
      break;
  }

  distance = ((duration / 2) / 29.1); //Convert time to Cm
  return distance;
}

void setup() {
  // put your setup code here, to run once:
  pinMode(trigPin, OUTPUT); //Setup Trigger and Echo
  pinMode(echoPin1, INPUT);
  pinMode(echoPin2, INPUT);
  pinMode(isGarbage, INPUT);
  pinMode(isWet, INPUT);
  Serial.begin(115200);
  lcd.begin();
  lcd.clear();
    WiFi.begin(WIFI_SSID, WIFI_PASSWORD);
    Serial.print("Connecting to Wi-Fi");
    lcd.print("Connecting....");
    while (WiFi.status() != WL_CONNECTED)
    {
     Serial.print(".");
     delay(300);
    }
     Firebase.begin(FIREBASE_HOST, FIREBASE_AUTH);
    Firebase.reconnectWiFi(true);

    //Set database read timeout to 1 minute (max 15 minutes)
    Firebase.setReadTimeout(firebaseData, 1000 * 60);
    //tiny, small, medium, large and unlimited.
    //Size and its write timeout e.g. tiny (1s), small (10s), medium (30s) and large (60s).
    Firebase.setwriteSizeLimit(firebaseData, "tiny");
    //--------------
  S1.attach(servoPin1);
  S1.write(ReadyPos);
  delay(1000);
//  lcd.begin();
  lcd.clear();
  lcd.print("DRY WET _______");
  
           //012345678912345
}
int binSize = 35;

void loop() {
  if (Serial.available())
  {
    char ch = Serial.read();
    Serial.print(ch);
    if (ch == 'D' || ch == 'W')
      ServoControl(ch);
  }
  // put your main code here, to run repeatedly:
  int Ultrasonic_dry = ultrasonic(2);
  delay(50);
  int Ultrasonic_wet = ultrasonic(1);
  delay(50);
  Serial.println("Ultrasonic_dry : " + String(Ultrasonic_dry) + " Ultrasonic_wet : " + String(Ultrasonic_wet));
  Ultrasonic_dry = 100 - (Ultrasonic_dry * 100 ) / binSize;
  Ultrasonic_wet = 100 - (Ultrasonic_wet * 100 ) / binSize;
  if (Ultrasonic_dry < 0)
    Ultrasonic_dry = 0;
  if (Ultrasonic_wet < 0)
    Ultrasonic_wet = 0;
  if (Ultrasonic_dry > 100)
    Ultrasonic_dry = 100;
  if (Ultrasonic_wet > 100)
    Ultrasonic_wet = 100;
  Serial.println("B1=" + String(Ultrasonic_dry) + "% B2=" + String(Ultrasonic_wet) + "%");
  lcd.setCursor(0,1);// pos, line
  lcd.print("    ");
  lcd.setCursor(0,1);
  lcd.print(Ultrasonic_dry);

  lcd.setCursor(4,1);
  lcd.print("    ");
  lcd.setCursor(4,1);
  lcd.print(Ultrasonic_wet);
  if(Firebase.setString(firebaseData, DataPathDry , String(Ultrasonic_dry)))
    {
      Serial.print(DataPathDry + ":" +String(Ultrasonic_dry));
      Serial.println("--published");
      //Serial.println("int array pushed");
    }
    else
      Serial.println("fails");
      delay(100);
   if(Firebase.setString(firebaseData, DataPathWet , String(Ultrasonic_wet)))
    {
      Serial.print(DataPathWet + ":" +String(Ultrasonic_wet));
      Serial.println("--published");
      //Serial.println("int array pushed");
    }
    else
      Serial.println("failse");
  
  delay(300);
  if (analogRead(isGarbage) > 950)
  {
    Serial.print("Garbage - ");
    delay(3000); // 3 sec
    lcd.setCursor(9,0);
    lcd.print("Garbage");
    if (digitalRead(isWet) == LOW)
    {
      lcd.setCursor(10,1);
      lcd.print("WET");
      Serial.println("WET ");
      delay(1000);
      ServoControl('W');
    }
    else
    {
      lcd.setCursor(10,1);
      lcd.print("DRY");
      Serial.println("Dry ");
      delay(1000);
      ServoControl('D');
    }
    
    lcd.setCursor(9,0);
    lcd.print("_______");
    lcd.setCursor(10,1);
    lcd.print("   ");
  }
}

void ServoControl(char ch)
{
  if (ch == 'D')
  {
    Serial.print("DRY>Tilting>");
    for (int i = ReadyPos; i <= DryPos; i = i + 10)
    {
      S1.write(i);
      delay(50);
    }
    delay(2000);
    Serial.print("BackToNormal");
    for (int i = DryPos; i >= ReadyPos; i = i - 10)
    {
      S1.write(i);
      delay(50);
    }
    Serial.print("Ready");
    delay(1000);
  }
  else if (ch == 'W')
  {
    Serial.print("WET>Tilting>");
    for (int i = ReadyPos; i >= WetPos; i = i - 10)
    {
      S1.write(i);
      delay(50);
    }
    delay(2000);
    Serial.print("BackToNormal");
    for (int i = WetPos; i <= ReadyPos; i = i + 10)
    {
      S1.write(i);
      delay(50);
    }
    Serial.print("Ready");
      delay(1000);

  }
}

#include <WiFi.h>
#include <HTTPClient.h>

const char* ssid = "EnriqueS22"; 
const char* password = "Galletas123";  

String serverUrl = "http://192.168.93.151/aeras/guardar_lectura.php";  

const int redPin = 27;
const int greenPin = 26;
const int bluePin = 25;

const int freq = 5000;
const int resolution = 8;

const int EFECTOS_NEGATIVOS = 1100;
const int VENTILACION_REQUERIDA = 600;

String dispositivo_id = "ESP32_001"; 

void setup() {
  Serial.begin(19200); 
  pinMode(redPin, OUTPUT);
  pinMode(greenPin, OUTPUT);
  pinMode(bluePin, OUTPUT);

  ledcSetup(0, freq, resolution);
  ledcSetup(1, freq, resolution);
  ledcSetup(2, freq, resolution);

  ledcAttachPin(redPin, 0);
  ledcAttachPin(greenPin, 1);
  ledcAttachPin(bluePin, 2);

  // Conexión Wi-Fi
  WiFi.begin(ssid, password);
  Serial.print("Conectando a Wi-Fi...");
  while (WiFi.status() != WL_CONNECTED) {
    delay(1000);
    Serial.print(".");
  }
  Serial.println("Conectado a Wi-Fi");
}

void loop() {

  int valor_MQ = analogRead(A6);

  String frase = "CO2: " + String(valor_MQ) + " PPM";
  Serial.println(frase); 

 
  if (valor_MQ >= EFECTOS_NEGATIVOS) {
    setColor(255, 0, 0);  
  } else if (valor_MQ < EFECTOS_NEGATIVOS && valor_MQ > VENTILACION_REQUERIDA) {
    setColor(0, 255, 255);  
  } else {
    setColor(0, 255, 0);  
  }
  enviarDatos(valor_MQ, frase);

  delay(3000);
}

void setColor(int red, int green, int blue) {
  ledcWrite(0, red);
  ledcWrite(1, green);
  ledcWrite(2, blue);
}

void enviarDatos(int valor_mq, String estado) {
  if (WiFi.status() == WL_CONNECTED) {
    HTTPClient http;
  
    http.begin(serverUrl);  
    http.addHeader("Content-Type", "application/x-www-form-urlencoded"); 
    String postData = "dispositivo_id=" + dispositivo_id + "&co2_ppm=" + String(valor_mq) + "&estado=" + estado;

    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String response = http.getString();
      Serial.println("Respuesta del servidor: " + response);
    } else {
      Serial.println("Error al enviar los datos: " + String(httpResponseCode));
    }

    http.end();
  } else {
    Serial.println("Error: No conectado a Wi-Fi");
  }
}



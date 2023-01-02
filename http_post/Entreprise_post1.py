import requests

url = 'http://API.test:8011/API/Creer-Fiche-Entreprise'
url = 'http://plusdeca.api2/API/Creer-Fiche-Entreprise'



myobj = [ ('Submit' , '1'), {'debug','1'}, ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'),('Siret','112'), ( 'Nom' , 'Adaptive Research' ) , ( 'Email' , 'contact@adaptive-research.eu' ),('Telephone','+33 6 98 86 38 94') ]

x = requests.post(url, data = myobj)
print(x.text)


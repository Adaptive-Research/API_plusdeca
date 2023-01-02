import requests

url = 'https://plusdeca.adaptive-api.fr/API/Search-Entreprises'



myobj = [ ('Submit' , '1'), ('debug','1'), ('token', '1;6adb778327adece320bc12c8a982b6681eafe1fa1f804931843cb0bb7f22'),('Searching','A') ]

x = requests.post(url, data = myobj)
print(x.text)


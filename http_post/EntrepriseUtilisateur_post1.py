import requests

url = 'https://plusdeca.adaptive-api.fr/API/Show-Entreprise-Utilisateur'



myobj = [ ('Submit' , '1'), ('debug','1'), ('token', '20;fea51afbe9f62604dada08af5a28437ebf52b4d22c8a50310cef15cb4d7e') ]

x = requests.post(url, data = myobj)
print(x.text)


import requests

url = 'https://test.adaptive-api.fr/Images/2/'




x = requests.get(url)
print(x.text)


import requests

url = 'https://test.adaptive-api.fr/API/Show-Articles'



myobj = [ ('Submit' , '1'), ('debug' , '1'),  ('token', ' 3;82944edc57291fb4623201dfa83b2707484f9c99922123979ae57df15937')  ]

x = requests.post(url, data = myobj)
print(x.text)


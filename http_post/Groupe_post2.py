import requests

url = 'https://test.adaptive-api.fr/API/Show-All-Groupes'



myobj = [ ('Submit' , '1'), ('debug','1'), ('token', '1;a84f0dfb611997f48fb65e1ab07c1f0e98ce230d745ee0421cf985b75391')  ]

x = requests.post(url, data = myobj)
print(x.text)


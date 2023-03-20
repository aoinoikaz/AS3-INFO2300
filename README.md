# AS3-INFO2300

My in real life client manufactures and sells vape products (they are one of the biggest legal vape distributors in Canada), through a variety of sales channels including Shopify and other e-commerce platforms. I have developed the entirety of their IT stack, so I decided to use this small php backend service as the case study for my INFO2300 assignment (as it fit in with the scope of the assignment).


## What is it?

Natively, shopify does not handle file uploads, so I was tasked with developing a solution to allow customers to upload their identification when they signup for a wholesale account. Customers fill out the wholesale form, and can choose to upload their images. It will then send those images to this php backend, which will encrypt, process and store the images. Then a URL to the image resource will be generated and sent back in the response to the front end for use. The front end will take the URL and pass it into the shopify contact submission (which is sent to shopify merchant emails). For propietary reasons, I will only post the image upload logic in repository. 

#### Example snippet of customer submission sent to Shopify Admin/Merchant
![An example of contact form submission](https://cdn.discordapp.com/attachments/863254730113417277/1087462704790372403/image.png)

![An example of the generated resource that company admin can view](https://cdn.discordapp.com/attachments/863254730113417277/1087463742012391534/image.png)

## Where is it?
-This script is deployed to clients VPS (similar to dedicated server)  
-RDP access  
-I had to configure and setup specific authorization and security on server  
-IIS web server  
-"OVH" hosting company  

This is currently live in production (beta) and can be viewed here: https://thedistro.ca/pages/whole-sale

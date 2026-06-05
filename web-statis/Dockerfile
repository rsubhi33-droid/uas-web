# Menggunakan base image Nginx Alpine yang ringan
FROM nginx:alpine

# Menyalin seluruh aset web statis ke direktori default Nginx
COPY . /usr/share/nginx/html/

# Mengekspos port 80 untuk lalu lintas HTTP
EXPOSE 80

# Menjalankan Nginx di foreground
CMD ["nginx", "-g", "daemon off;"]
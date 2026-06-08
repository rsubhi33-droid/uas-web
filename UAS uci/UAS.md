## Komponen dan Infrastruktur

1. Membuat Instance baru
![alt text](image.png)
2. Setting security group
![alt text](image-1.png)
3. Membuat Elastic IP
![alt text](image-2.png)
4. Karena kita menggunakan instance baru, install based docker dokumen https://docs.docker.com/engine/install/ubuntu/
5. Membuat Repository baru di docker.hub untuk web-statis & web-dinamis
![alt text](image-3.png)
![alt text](image-4.png)
6. Membuat Repository di github untuk uas web-statis & web-dinamis
7. Mengisi Secrets Variable di github action
![alt text](image-5.png)
8. Melakukan Edit File Pipeline di Github
   - didalam web-statis buat file index.html dan Dockerfile (bisa buat baru atau mengambil dari web cv saat uts)
   - Buat Folder Baru .github -> Buat folder workflows -> Buat File deploy-statis.yml
9. Sebelum melakukan commit dan synch pada file
   - Pastikan user ubuntu sudah ditambahkan ke docker -> sudo usermod -aG docker ubuntu
   - Baru lakukan commit dan push ke Github
   ![alt text](image-6.png)
10. Cek apakah web-statis sudah berjalan dengan baik
![alt text](image-7.png)
11. Deploy Multiple Container menggunakan Docker Compose
12. Buat file Dockerfile
13. Buat file docker-compose.yml
14. Buat Workflows File -> deploy-dinamis.yml di folder .github/workflows/
15. Buat juga Struktur folder web dinamis seperti yang kita mau
16. Edit File -> deploy-dinamis.yml di folder .github/workflows/
17. Commit & Push Changes ke GitHub
18. Cek di Github, apakah actions jalan dan berhasil
![alt text](image-8.png)
19. Akses web melalui Browser dengan Port 3000
![alt text](image-9.png)
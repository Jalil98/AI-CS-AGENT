DOKUMENTASI TEKNIS
AI CS AGENT – FLOW GADAI EMAS
Silahkan install dulu requirement yang dibutuhkan sebelum menjalankan proyek:
1.	Docker
2.	Ngrok
3.	Xampp
4.	n8n
5.	Download file workflow canvas n8n --> https://github.com/Jalil98/AI-CS-AGENT/blob/main/.n8n/AI%20CS%20Agent.json
6.	upload file pada step 5 di n8n
  
WORKFLOW N8N 
 <img width="993" height="447" alt="image" src="https://github.com/user-attachments/assets/e9d7763a-8686-4184-9251-456a054cb7ed" />

 
Desain Arsitektur AI CS AGENT:
 <img width="900" height="886" alt="image" src="https://github.com/user-attachments/assets/270e82ca-5848-48ff-a6e3-b47a6ef7b13e" />

 
1. Setup dan Menjalankan Sistem
Sistem AI CS Agent dijalankan menggunakan Docker untuk memastikan isolasi environment dan kemudahan deployment. Berikut adalah tahapan menjalankan sistem menggunakan Docker dan ngrok.
Buka Docker desktop dan setelah docker sudah running, jalankan perintah ini satu persatu:
1.1 Perintah Docker
docker restart n8n
 <img width="900" height="886" alt="image" src="https://github.com/user-attachments/assets/90751742-4216-4fa0-807d-1c4bdbadbf97" />

Digunakan untuk menghentikan dan menjalankan kembali container n8n. Biasanya dilakukan jika terjadi error atau perubahan konfigurasi ringan.
docker stop n8n
 <img width="794" height="198" alt="image" src="https://github.com/user-attachments/assets/99cfbf84-c595-48fc-8125-de1aca4ff577" />

Digunakan untuk menghentikan container n8n tanpa menghapusnya dari sistem.
 
ngrok http 5678
 <img width="794" height="198" alt="image" src="https://github.com/user-attachments/assets/fe73dc17-7aa3-4df0-9ce8-24d15bb69c19" />

Digunakan untuk membuat tunnel HTTPS publik agar Telegram dapat mengakses webhook n8n.
Akan menampilkan hasil dengan server yang bisa dijalankan dilocal host:
 <img width="900" height="248" alt="image" src="https://github.com/user-attachments/assets/655c806a-475d-40aa-99a8-4fef767d4cdd" />

Klik: http://localhost:5678

2. Arsitektur Flow Gadai Emas
Flow Gadai Emas terdiri dari beberapa node utama dalam workflow n8n yang saling terhubung untuk memproses permintaan user.
2.1 Telegram Trigger
Menerima pesan dari user Telegram dan menangkap chat ID, nama user, serta isi pesan.
2.2 AI Agent (Gemini + Memory)
Mengklasifikasikan intent user menjadi JSON terstruktur seperti ‘pilih_emas’ atau ‘input_gram’.
2.3 Switch (Intent Router)
Mengalihkan alur berdasarkan intent yang diterima. Untuk Flow Emas digunakan intent: pilih_emas dan input_gram.
2.4 HTTP Gold API
Mengambil harga emas realtime dari MetalPriceAPI dalam satuan XAU terhadap IDR.
2.5 Perhitungan Estimasi
Harga per gram dihitung dengan membagi harga per ounce dengan 31.1035. Estimasi gadai dihitung dengan mengalikan harga per gram dengan berat emas dari user.
2.6 Validasi dan Response
Sistem memvalidasi bahwa estimasi lebih dari 0 sebelum mengirimkan hasil ke user Telegram.
2.7 Reporting ke Dashboard
Jika estimasi berhasil dihitung, sistem mengirimkan data ke report.php melalui HTTP POST untuk disimpan ke reports.json dan ditampilkan pada dashboard.php.
3. Arsitektur Sistem
Telegram User → n8n (Docker) → AI Agent → Gold API → Perhitungan → Send Message → Report API (PHP) → Storage (JSON) → Dashboard Web
4. Kesimpulan
Flow Gadai Emas berhasil diimplementasikan dengan integrasi LLM untuk klasifikasi intent, API harga emas realtime, perhitungan otomatis, serta sistem reporting dashboard berbasis PHP. Sistem mendukung multi-user dan siap untuk dikembangkan lebih lanjut.
FINAL REPORT SISTEM GADAI ELEKTRONIK BERBASIS AI
Tanggal Pembuatan: 01 March 2026

5. Overview Sistem Elektronik
Sistem Gadai Elektronik berbasis AI merupakan bagian dari AI CS Agent yang dibangun menggunakan n8n sebagai workflow orchestrator, Gemini sebagai AI intent classifier, dan Qdrant sebagai vector database untuk pencarian harga barang elektronik berbasis RAG (Retrieval-Augmented Generation).
6. Tujuan Sistem
Tujuan sistem ini adalah:
• Mengotomatisasi proses estimasi gadai elektronik.
• Menggunakan AI untuk memahami intent pengguna.
• Menghitung estimasi nilai gadai berdasarkan wilayah.
• Mencatat transaksi berhasil ke dashboard reporting.
7. Flow Sistem Elektronik
Alur kerja sistem elektronik adalah sebagai berikut:
1. User memilih opsi 'Elektronik'.
2. Bot meminta pengguna menyebutkan jenis dan tipe barang.
3. Sistem melakukan pencarian harga di Qdrant Vector Database.
4. Jika score similarity di atas threshold → barang ditemukan.
5. Sistem menyimpan harga_unit ke Static Session berdasarkan chat_id.
6. Bot meminta pengguna memasukkan wilayah.
7. Sistem menghitung estimasi berdasarkan persentase wilayah.
8. Jika estimasi > 0 → data dikirim ke backend PHP (report.php).
9. Dashboard menampilkan data transaksi secara realtime.
8. Logic Perhitungan Estimasi
Persentase estimasi berdasarkan wilayah:
• Jawa Barat  → 70% dari harga unit
• DKI Jakarta → 80% dari harga unit
• Jawa Timur  → 60% dari harga unit
• Wilayah lain → 50% dari harga unit
Rumus perhitungan:
Estimasi = harga_unit × persen_wilayah
9. Reporting & Dashboard
Sistem hanya mencatat ke dashboard jika:
• Harga barang ditemukan
• Estimasi berhasil dihitung
• Estimasi lebih dari 0
Data yang disimpan ke database:
• Nama User
• Jenis Barang (elektronik)
• Pertanyaan User (wilayah)
• Estimasi Nilai Barang
• Timestamp
10. Arsitektur Sistem
Telegram User → Telegram Bot → n8n AI Agent → Qdrant RAG → Business Logic (Code Hitung) → HTTP POST → PHP Backend → Database → Dashboard
11. Kesimpulan
Sistem Gadai Elektronik berbasis AI ini mengintegrasikan LLM (Gemini), Vector Search (Qdrant), serta backend PHP untuk reporting dashboard. Sistem mampu melakukan estimasi otomatis secara real-time dan menyimpan transaksi yang valid untuk monitoring dan analisis lebih lanjut.



 
TEST telegram bot AI CS AGENT -->  https://t.me/gadai_ai_bot

<img width="884" height="657" alt="image" src="https://github.com/user-attachments/assets/988a4dc3-840c-431a-82bf-72bafadfc688" />

LINK VIDEO DEMO:
https://youtu.be/6cKvuSg2954






REPORT DASHBOARD AI CS AGENT 

<img width="900" height="320" alt="image" src="https://github.com/user-attachments/assets/5861c7dd-7a32-45b3-a221-e96e28ca53a1" />

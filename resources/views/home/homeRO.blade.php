@extends('layouts.app')

@section('content')
    <main class="p-8">
        <h1 class="text-3xl font-bold text-green-700">
            Hi, {{ $user->name }}
        </h1>
        <h2 class="text-2xl font-bold text-gray-800 mt-2">
            Sampah yang dapat didaur ulang
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mt-8">
            <div class="text-center hover-grow hover-move shadow-lg p-6 rounded-lg bg-white">
                <div class="bg-blue-100 rounded-full w-32 h-32 mx-auto flex items-center justify-center">
                    <img alt="Image of plastic bottles" class="hover-grow" height="64"
                        src="{{ asset('images/botolPlastik.svg') }}" width="180" />
                </div>
                <h3 class="text-xl font-bold mt-4">
                    Plastik
                </h3>
                <p class="text-gray-600 mt-2">
                    Plastik adalah salah satu jenis sampah yang paling umum. Beberapa plastik bisa didaur ulang, seperti
                    botol minuman plastik (PET).
                </p>
            </div>
            <div class="text-center hover-grow hover-move shadow-lg p-6 rounded-lg bg-white">
                <div class="bg-blue-100 rounded-full w-32 h-32 mx-auto flex items-center justify-center">
                    <img alt="Image of glass bottle" class="hover-grow" height="64"
                        src="{{ asset('images/botolKaca.svg') }}" width="32" />
                </div>
                <h3 class="text-xl font-bold mt-4">
                    Kaca
                </h3>
                <p class="text-gray-600 mt-2">
                    Botol kaca, toples, dan jenis kaca lainnya juga bisa didaur ulang. Proses daur ulang kaca dapat
                    menghasilkan produk kaca baru tanpa kehilangan kualitas.
                </p>
            </div>
            <div class="text-center hover-grow hover-move shadow-lg p-6 rounded-lg bg-white">
                <div class="bg-blue-100 rounded-full w-32 h-32 mx-auto flex items-center justify-center">
                    <img alt="Image of paper" class="hover-grow" height="64" src="{{ asset('images/kertas.svg') }}"
                        width="70" />
                </div>
                <h3 class="text-xl font-bold mt-4">
                    Kertas
                </h3>
                <p class="text-gray-600 mt-2">
                    Kertas yang dapat didaur ulang, seperti koran, majalah, dan kardus, membantu mengurangi penebangan pohon
                    untuk produksi kertas baru.
                </p>
            </div>
            <div class="text-center hover-grow hover-move shadow-lg p-6 rounded-lg bg-white">
                <div class="bg-blue-100 rounded-full w-32 h-32 mx-auto flex items-center justify-center">
                    <img alt="Image of paper" class="hover-grow" height="64" src="{{ asset('images/kaleng.svg') }}"
                        width="64" />
                </div>
                <h3 class="text-xl font-bold mt-4">
                    Kaleng
                </h3>
                <p class="text-gray-600 mt-2">
                    Kaleng yang dapat didaur ulang, seperti kaleng aluminium dan minuman, membantu mengurangi sampah dan
                    penggunaan energi dalam pembuatan kaleng baru.
                </p>
            </div>
        </div>

        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800">
                Mengapa Daur Ulang Penting?
            </h2>
            <p class="text-gray-600 mt-4">
                Daur ulang membantu mengurangi jumlah sampah yang berakhir di tempat pembuangan akhir, mengurangi
                polusi, dan menghemat sumber daya alam. Dengan mendaur ulang, kita juga dapat mengurangi emisi gas rumah
                kaca dan membantu melindungi lingkungan.
            </p>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Mengurangi Polusi
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Daur ulang membantu mengurangi polusi udara dan air dengan mengurangi kebutuhan untuk
                        mengumpulkan bahan mentah baru.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Menghemat Energi
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Proses daur ulang biasanya menggunakan lebih sedikit energi dibandingkan dengan membuat produk
                        baru dari bahan mentah.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Melindungi Ekosistem
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Dengan mengurangi kebutuhan untuk menambang dan menebang, daur ulang membantu melindungi habitat
                        alami dan keanekaragaman hayati.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Mengurangi Emisi Gas Rumah Kaca
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Daur ulang membantu mengurangi emisi gas rumah kaca yang berkontribusi terhadap perubahan iklim.
                    </p>
                </div>
            </div>
        </section>
        <section class="mt-12">
            <h2 class="text-2xl font-bold text-gray-800">
                Cara Mendaur Ulang dengan Benar
            </h2>
            <p class="text-gray-600 mt-4">
                Mendaur ulang dengan benar sangat penting untuk memastikan bahwa bahan-bahan yang didaur ulang dapat
                digunakan kembali dengan efektif. Berikut adalah beberapa tips untuk mendaur ulang dengan benar:
            </p>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Pisahkan Sampah
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Pisahkan sampah berdasarkan jenisnya, seperti plastik, kaca, kertas, dan logam. Ini akan
                        memudahkan proses daur ulang.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Bersihkan Sampah
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Pastikan sampah yang akan didaur ulang dalam keadaan bersih. Cuci botol dan wadah makanan
                        sebelum memasukkannya ke tempat daur ulang.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Gunakan Tempat Sampah yang Tepat
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Gunakan tempat sampah yang telah disediakan untuk masing-masing jenis sampah. Ini akan
                        membantu proses daur ulang berjalan lebih efisien.
                    </p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-lg hover-move">
                    <h3 class="text-xl font-bold text-green-700">
                        Kurangi Penggunaan Plastik
                    </h3>
                    <p class="text-gray-600 mt-2">
                        Kurangi penggunaan plastik sekali pakai dan beralih ke alternatif yang lebih ramah lingkungan,
                        seperti tas belanja kain dan botol minum yang dapat digunakan kembali.
                    </p>
                </div>
            </div>
        </section>
    </main>
    <footer class="bg-green-600 p-4 mt-12 text-white text-center">
        <p>
            © 2023 Recycling Initiative. All rights reserved.
        </p>
        <div class="mt-2">
            <a class="text-white hover:text-gray-300 transition-colors mx-2" href="#">
                <i class="fab fa-facebook-f">
                </i>
            </a>
            <a class="text-white hover:text-gray-300 transition-colors mx-2" href="#">
                <i class="fab fa-twitter">
                </i>
            </a>
            <a class="text-white hover:text-gray-300 transition-colors mx-2" href="#">
                <i class="fab fa-instagram">
                </i>
            </a>
        </div>
    </footer>
@endsection

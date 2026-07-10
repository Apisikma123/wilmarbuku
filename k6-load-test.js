import http from 'k6/http';
import { check, sleep, group } from 'k6';
import { parseHTML } from 'k6/html';

export const options = {
    stages: [
        { duration: '30s', target: 50 },  // Ramp-up to 50 users
        { duration: '30s', target: 100 }, // Ramp-up to 100 users
        { duration: '30s', target: 200 }, // Ramp-up to 200 users
        { duration: '1m', target: 300 },  // Sustain 300 users
        { duration: '30s', target: 0 },   // Ramp-down
    ],
    thresholds: {
        http_req_duration: ['p(95)<2000'], // 95% of requests should be below 2s
        http_req_failed: ['rate<0.01'],    // Error rate < 1%
    },
};

const BASE_URL = 'http://localhost:8000';

export default function () {
    let res;
    let csrfToken = '';

    group('1. Visit Homepage & Get CSRF', function () {
        res = http.get(`${BASE_URL}/`);
        check(res, {
            'Homepage status is 200': (r) => r.status === 200,
            'Homepage has text': (r) => r.body.includes('Katalog Buku'),
        });

        // Extract CSRF token
        const doc = parseHTML(res.body);
        const tokenElement = doc.find('meta[name="csrf-token"]');
        if (tokenElement.length > 0) {
            csrfToken = tokenElement.attr('content');
        }
        sleep(1);
    });

    group('2. Login', function () {
        res = http.post(`${BASE_URL}/login`, {
            _token: csrfToken,
            email: 'user@example.com', // Ganti dengan kredensial test
            password: 'password123',
        });
        check(res, {
            'Login redirect': (r) => r.status === 302 || r.status === 200,
        });
        sleep(2);
    });

    group('3. View Dashboard', function () {
        res = http.get(`${BASE_URL}/dashboard`);
        check(res, {
            'Dashboard loaded': (r) => r.status === 200,
        });
        sleep(1);
    });

    group('4. Search Buku', function () {
        res = http.get(`${BASE_URL}/kategori?search=pemrograman`);
        check(res, {
            'Search loaded': (r) => r.status === 200,
        });
        sleep(1);
    });

    group('5. Detail Buku', function () {
        // Asumsikan buku ID 1 ada
        res = http.get(`${BASE_URL}/buku/1`);
        check(res, {
            'Book detail loaded': (r) => r.status === 200 || r.status === 404,
        });
        sleep(2);
    });

    group('6. Add to Cart', function () {
        res = http.post(`${BASE_URL}/cart/add/1`, {
            _token: csrfToken,
            qty: 1,
            pesan_dukungan: 'Load test message'
        });
        check(res, {
            'Added to cart successfully': (r) => r.status === 200 || r.status === 302,
        });
        sleep(1);
    });

    group('7. Checkout Process', function () {
        res = http.post(`${BASE_URL}/checkout`, {
            _token: csrfToken,
            tipe_donatur: 'eksternal',
            nama_lengkap: 'Load Test User',
            email: 'loadtest@example.com'
        });
        check(res, {
            'Checkout redirect': (r) => r.status === 302 || r.status === 200,
        });
        sleep(2);
    });

    group('8. Logout', function () {
        res = http.post(`${BASE_URL}/logout`, {
            _token: csrfToken
        });
        check(res, {
            'Logout successful': (r) => r.status === 302 || r.status === 200,
        });
    });
}

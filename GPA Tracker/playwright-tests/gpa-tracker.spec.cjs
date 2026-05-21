// ============================================================
//  GPA Tracker — Playwright Test Suite
//  All 10 Test Cases (TC-01 to TC-10)
//  Run: npx playwright test --headed
// ============================================================

const { test, expect } = require('@playwright/test');

// ── Helper: login karne ke liye reusable function ──────────
async function login(page, email, password) {
  await page.goto('/login');
  await page.fill('input[name="email"]', email);
  await page.fill('input[name="password"]', password);
  await page.click('button[type="submit"]');
}

// ============================================================
// TC-01: Already used email se register karo
// Expected: Email field pe validation error aaye
// ============================================================
test('TC-01 - Duplicate email registration shows error', async ({ page }) => {
  await page.goto('/register');

  await page.fill('input[name="name"]', 'Test User');
  await page.fill('input[name="email"]', 'amenaiftekhar576@gmail.com'); // ← apna already registered email yahan daalo
  await page.fill('input[name="password"]', '123456');
  await page.fill('input[name="password_confirmation"]', '123456');
  await page.click('button[type="submit"]');

  // Error alert visible hona chahiye
  await expect(page.locator('.alert-danger')).toBeVisible();
  await expect(page.locator('.alert-danger')).toContainText('already been taken');
});

// ============================================================
// TC-02: Email verify kiye baghair login karo
// Expected: Verification message ke saath block ho
// ============================================================
test('TC-02 - Login blocked before email verification', async ({ page }) => {
  await page.goto('/login');

  await page.fill('input[name="email"]', 'aqsaaslam182005@gmail.com'); // ← unverified account email
  await page.fill('input[name="password"]', '123456');
  await page.click('button[type="submit"]');

  // Warning ya info message aana chahiye verification ke baare mein
  const body = page.locator('body');
  await expect(body).toContainText(/verify|verification|verified/i);
});

// ============================================================
// TC-03: End date ≤ Start date wala semester add karo
// Expected: Validation error aaye
// ============================================================
test('TC-03 - Semester with invalid dates shows error', async ({ page }) => {
  // Pehle login karo
  await login(page, 'amenaiftekhar576@gmail.com', '123456'); // ← apna valid account

  await page.goto('/semesters/create');

  await page.fill('input[name="name"]', 'Test Semester');
  await page.fill('input[name="start_date"]', '2024-06-01');
  await page.fill('input[name="end_date"]', '2024-01-01'); // end < start — invalid
  await page.click('button[type="submit"]');

  // Error dikhna chahiye
  await expect(page.locator('.alert-danger, .invalid-feedback')).toBeVisible();
});

// ============================================================
// TC-04: Doosre user ke semester mein course add karo
// Expected: HTTP 403 Forbidden
// ============================================================
test('TC-04 - Adding course to another users semester returns 403', async ({ page }) => {
  // Apne account se login karo
  await login(page, 'amenaiftekhar576@gmail.com', '123456'); // ← apna account

  // Doosre user ka semester ID URL mein daalo (jaise ID = 999)
  const response = await page.goto('/semesters/999/courses/create');

  // 403 aana chahiye
  expect(response.status()).toBe(403);
});

// ============================================================
// TC-05: Grade add karo weightage=50, marks=80/100
// Expected: percentage=80, letter=A−
// ============================================================
test('TC-05 - Grade computation: weightage=50, 80/100 = A-', async ({ page }) => {
  await login(page, 'amenaiftekhar576@gmail.com', '123456');

  // Apne course ke grades page pe jao (ID adjust karo)
  await page.goto('/courses/1/grades/create'); // ← apna course ID daalo

  await page.selectOption('select[name="type"]', 'Quiz');
  await page.fill('input[name="weightage"]', '50');
  await page.fill('input[name="marks_obtained"]', '80');
  await page.fill('input[name="total_marks"]', '100');
  await page.click('button[type="submit"]');

  // Result page pe percentage aur letter grade check karo
  await expect(page.locator('body')).toContainText('80');
  await expect(page.locator('body')).toContainText('A-');
});

// ============================================================
// TC-06: Same date pe duplicate attendance add karo
// Expected: Validation error aaye
// ============================================================
test('TC-06 - Duplicate attendance for same date shows error', async ({ page }) => {
  await login(page, 'amenaiftekhar576@gmail.com', '123456');

  // Pehli baar attendance mark karo
  await page.goto('/courses/1/attendance/create'); // ← apna course ID
  await page.fill('input[name="date"]', '2024-03-15');
  await page.selectOption('select[name="status"]', 'present');
  await page.click('button[type="submit"]');

  // Dobaara same date pe mark karo
  await page.goto('/courses/1/attendance/create');
  await page.fill('input[name="date"]', '2024-03-15');
  await page.selectOption('select[name="status"]', 'absent');
  await page.click('button[type="submit"]');

  // Error aana chahiye
  await expect(page.locator('.alert-danger, .invalid-feedback')).toBeVisible();
});

// ============================================================
// TC-07: Koi graded course nahi — transcript PDF download karo
// Expected: PDF generate ho, GPA = 0
// ============================================================
test('TC-07 - Transcript PDF with no graded courses shows GPA 0', async ({ page }) => {
  await login(page, 'amenaiftekhar576@gmail.com', '123456'); // ← aisa account jisme koi grade nahi

  const [download] = await Promise.all([
    page.waitForEvent('download'),
    page.goto('/report/transcript/pdf')
  ]);

  // PDF download hua
  expect(download.suggestedFilename()).toContain('.pdf');

  // Ya HTML transcript page pe GPA check karo
  await page.goto('/report/transcript');
  await expect(page.locator('body')).toContainText(/0\.00|GPA.*0/i);
});

// ============================================================
// TC-08: Expired password reset token use karo
// Expected: Login page pe redirect ho, error aaye
// ============================================================
test('TC-08 - Expired reset token redirects with error', async ({ page }) => {
  // Purana / fake token use karo
  await page.goto('/password/reset/this-is-an-expired-or-fake-token-abc123');

  // Login page pe redirect aana chahiye ya error dikhna chahiye
  await expect(page).toHaveURL(/login|password/);
  await expect(page.locator('body')).toContainText(/invalid|expired|token/i);
});

// ============================================================
// TC-09: Admin pending user verify kare
// Expected: verified_by_admin_at field populate ho
// ============================================================
test('TC-09 - Admin verifies pending user', async ({ page }) => {
  // Admin account se login karo
  await login(page, 'amenaiftekhar576@gmail.com', '123456'); // ← admin credentials

  // Admin panel pe jao
  await page.goto('/admin/users');

  // Pending user ke saath "Verify" button click karo
  await page.locator('text=Verify').first().click();

  // Confirmation aana chahiye
  await expect(page.locator('.alert-success, body')).toContainText(/verified|success/i);
});

// ============================================================
// TC-10: Same IP se 5 baar failed login
// Expected: Rate limit message aaye
// ============================================================
test('TC-10 - Five failed logins trigger rate limiting', async ({ page }) => {
  // 5 baar galat password se login try karo
  for (let i = 0; i < 5; i++) {
    await page.goto('/login');
    await page.fill('input[name="email"]', 'habiba@gmail.com');
    await page.fill('input[name="password"]', 'wrongpassword123');
    await page.click('button[type="submit"]');
  }

  // 5th attempt ke baad throttle message aana chahiye
  await expect(page.locator('body')).toContainText(/too many|throttle|try again/i);
});

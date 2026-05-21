# Instructions

- Following Playwright test failed.
- Explain why, be concise, respect Playwright best practices.
- Provide a snippet of code with the fix, if possible.

# Test info

- Name: gpa-tracker.spec.cjs >> TC-10 - Five failed logins trigger rate limiting
- Location: playwright-tests\gpa-tracker.spec.cjs:184:1

# Error details

```
Error: page.goto: Target page, context or browser has been closed
Call log:
  - navigating to "http://localhost:8000/login", waiting until "load"

```

# Test source

```ts
  87  | // Expected: percentage=80, letter=A−
  88  | // ============================================================
  89  | test('TC-05 - Grade computation: weightage=50, 80/100 = A-', async ({ page }) => {
  90  |   await login(page, 'amenaiftekhar576@gmail.com', '123456');
  91  | 
  92  |   // Apne course ke grades page pe jao (ID adjust karo)
  93  |   await page.goto('/courses/1/grades/create'); // ← apna course ID daalo
  94  | 
  95  |   await page.selectOption('select[name="type"]', 'Quiz');
  96  |   await page.fill('input[name="weightage"]', '50');
  97  |   await page.fill('input[name="marks_obtained"]', '80');
  98  |   await page.fill('input[name="total_marks"]', '100');
  99  |   await page.click('button[type="submit"]');
  100 | 
  101 |   // Result page pe percentage aur letter grade check karo
  102 |   await expect(page.locator('body')).toContainText('80');
  103 |   await expect(page.locator('body')).toContainText('A-');
  104 | });
  105 | 
  106 | // ============================================================
  107 | // TC-06: Same date pe duplicate attendance add karo
  108 | // Expected: Validation error aaye
  109 | // ============================================================
  110 | test('TC-06 - Duplicate attendance for same date shows error', async ({ page }) => {
  111 |   await login(page, 'amenaiftekhar576@gmail.com', '123456');
  112 | 
  113 |   // Pehli baar attendance mark karo
  114 |   await page.goto('/courses/1/attendance/create'); // ← apna course ID
  115 |   await page.fill('input[name="date"]', '2024-03-15');
  116 |   await page.selectOption('select[name="status"]', 'present');
  117 |   await page.click('button[type="submit"]');
  118 | 
  119 |   // Dobaara same date pe mark karo
  120 |   await page.goto('/courses/1/attendance/create');
  121 |   await page.fill('input[name="date"]', '2024-03-15');
  122 |   await page.selectOption('select[name="status"]', 'absent');
  123 |   await page.click('button[type="submit"]');
  124 | 
  125 |   // Error aana chahiye
  126 |   await expect(page.locator('.alert-danger, .invalid-feedback')).toBeVisible();
  127 | });
  128 | 
  129 | // ============================================================
  130 | // TC-07: Koi graded course nahi — transcript PDF download karo
  131 | // Expected: PDF generate ho, GPA = 0
  132 | // ============================================================
  133 | test('TC-07 - Transcript PDF with no graded courses shows GPA 0', async ({ page }) => {
  134 |   await login(page, 'amenaiftekhar576@gmail.com', '123456'); // ← aisa account jisme koi grade nahi
  135 | 
  136 |   const [download] = await Promise.all([
  137 |     page.waitForEvent('download'),
  138 |     page.goto('/report/transcript/pdf')
  139 |   ]);
  140 | 
  141 |   // PDF download hua
  142 |   expect(download.suggestedFilename()).toContain('.pdf');
  143 | 
  144 |   // Ya HTML transcript page pe GPA check karo
  145 |   await page.goto('/report/transcript');
  146 |   await expect(page.locator('body')).toContainText(/0\.00|GPA.*0/i);
  147 | });
  148 | 
  149 | // ============================================================
  150 | // TC-08: Expired password reset token use karo
  151 | // Expected: Login page pe redirect ho, error aaye
  152 | // ============================================================
  153 | test('TC-08 - Expired reset token redirects with error', async ({ page }) => {
  154 |   // Purana / fake token use karo
  155 |   await page.goto('/password/reset/this-is-an-expired-or-fake-token-abc123');
  156 | 
  157 |   // Login page pe redirect aana chahiye ya error dikhna chahiye
  158 |   await expect(page).toHaveURL(/login|password/);
  159 |   await expect(page.locator('body')).toContainText(/invalid|expired|token/i);
  160 | });
  161 | 
  162 | // ============================================================
  163 | // TC-09: Admin pending user verify kare
  164 | // Expected: verified_by_admin_at field populate ho
  165 | // ============================================================
  166 | test('TC-09 - Admin verifies pending user', async ({ page }) => {
  167 |   // Admin account se login karo
  168 |   await login(page, 'amenaiftekhar576@gmail.com', '123456'); // ← admin credentials
  169 | 
  170 |   // Admin panel pe jao
  171 |   await page.goto('/admin/users');
  172 | 
  173 |   // Pending user ke saath "Verify" button click karo
  174 |   await page.locator('text=Verify').first().click();
  175 | 
  176 |   // Confirmation aana chahiye
  177 |   await expect(page.locator('.alert-success, body')).toContainText(/verified|success/i);
  178 | });
  179 | 
  180 | // ============================================================
  181 | // TC-10: Same IP se 5 baar failed login
  182 | // Expected: Rate limit message aaye
  183 | // ============================================================
  184 | test('TC-10 - Five failed logins trigger rate limiting', async ({ page }) => {
  185 |   // 5 baar galat password se login try karo
  186 |   for (let i = 0; i < 5; i++) {
> 187 |     await page.goto('/login');
      |                ^ Error: page.goto: Target page, context or browser has been closed
  188 |     await page.fill('input[name="email"]', 'habiba@gmail.com');
  189 |     await page.fill('input[name="password"]', 'wrongpassword123');
  190 |     await page.click('button[type="submit"]');
  191 |   }
  192 | 
  193 |   // 5th attempt ke baad throttle message aana chahiye
  194 |   await expect(page.locator('body')).toContainText(/too many|throttle|try again/i);
  195 | });
```
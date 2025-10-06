import { test, expect } from "@playwright/test";

test("Laravel register berhasil dan muncul pesan sukses di halaman login", async ({
    page,
}) => {
    await page.goto("http://pbl-prestasi.test/register");

    const unique = Date.now();
    await page.fill('input[name="user_name"]', "Test User");
    await page.fill('input[name="user_username"]', "testuser" + unique);
    await page.fill('input[name="detail_student_nim"]', "NIM" + unique);
    await page.selectOption("#study_program_id", { index: 1 });
    await page.selectOption("#detail_student_gender", "male");
    await page.fill('input[name="detail_student_dob"]', "2000-01-01");

    const randomEmail = `test${unique}@example.com`;
    await page.fill('input[name="detail_student_email"]', randomEmail);
    await page.fill('input[name="detail_student_phone_no"]', "081234567890");
    await page.fill(
        'input[name="detail_student_address"]',
        "Jl. Testing Playwright No. 123"
    );

    await page.fill('input[name="user_password"]', "Test1234!");
    await page.fill('input[name="user_password_confirmation"]', "Test1234!");

    await page.click('button[type="submit"]');
    await page.waitForLoadState("networkidle");
    await page.waitForTimeout(2000);

    await expect(page).toHaveURL(/\/login$/);

    const pageText = await page.locator("body").innerText();
    expect(
        /registration successful|check your email|verifikasi email/i.test(
            pageText
        )
    ).toBeTruthy();

    await expect(page.locator('button[type="submit"]')).toBeVisible();

    await expect(page.locator('a[href*="register"]')).toBeVisible();
});

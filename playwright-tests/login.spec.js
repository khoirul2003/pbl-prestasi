import { test, expect } from "@playwright/test";

test("Laravel login berhasil", async ({ page }) => {
    await page.goto("http://pbl-prestasi.test/login");

    await expect(page).toHaveTitle(/Login/i);

    await page.fill('input[name="login_id"]', "admin");
    await page.fill('input[name="password"]', "Admin123!");

    await page.click('button[type="submit"]');

    await expect(page).toHaveURL("http://pbl-prestasi.test/admin");
    await expect(page.locator("body")).toContainText("Dashboard");
});

test("Laravel login gagal (password salah)", async ({ page }) => {
    await page.goto("http://pbl-prestasi.test/login");

    await expect(page).toHaveTitle(/Login/i);

    await page.fill('input[name="login_id"]', "admin");
    await page.fill('input[name="password"]', "wrongpassword");

    await page.click('button[type="submit"]');

    await expect(page).toHaveURL("http://pbl-prestasi.test/login");

    const bodyText = await page.locator("body").innerText();
    expect(/login credentials are incorrect/i.test(bodyText)).toBeTruthy();
});

test("Laravel logout berhasil dari dropdown navbar", async ({ page }) => {
    // --- Login ---
    await page.goto("http://pbl-prestasi.test/login");
    await page.fill('input[name="login_id"]', "admin");
    await page.fill('input[name="password"]', "Admin123!");
    await page.click('button[type="submit"]');

    await expect(page).toHaveURL("http://pbl-prestasi.test/admin");
    await expect(page.locator("body")).toContainText("Dashboard");

    // --- Logout ---
    await page.click("a.nav-link.dropdown-toggle");
    await page.waitForSelector(".dropdown-menu.show", { state: "visible" });
    await page.click('a:has-text("Sign Out")');

    await page.waitForLoadState("networkidle");
    await page.waitForTimeout(1500);

    await expect(page).toHaveURL(/\/login$/);

    const bodyText = await page.locator("body").innerText();
    expect(/Login|Masuk|SIGN IN|SIGN\s?In/i.test(bodyText)).toBeTruthy();
});

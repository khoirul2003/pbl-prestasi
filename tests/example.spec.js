import { test, expect } from '@playwright/test';

test('halaman login muncul', async ({ page }) => {
  await page.goto('http://prestasiku-pbl.test/login');
  await expect(page.locator('h1')).toContainText('Login');
});

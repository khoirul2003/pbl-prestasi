import { test, expect } from "@playwright/test";

test("Testing Department Update", async ({ page }) => {
    await page.goto("https://presken.my.id/login");
    await page.getByRole("textbox", { name: "Username / NIP / NIM" }).click();
    await page
        .getByRole("textbox", { name: "Username / NIP / NIM" })
        .fill("admin");
    await page.getByRole("textbox", { name: "Password" }).click();
    await page.getByRole("textbox", { name: "Password" }).fill("Admin123!");
    await page.getByRole("button", { name: "SIGN IN" }).click();
    await page.getByRole("link", { name: " Departments" }).click();
    await page.getByRole("button", { name: "" }).first().click();
    await page
        .getByRole("textbox", { name: "Department Name" })
        .fill("Teknologi Informasi Update");
    await page.getByRole("button", { name: "Update" }).click();
    await page.getByRole("link", { name: "Profile image " }).click();
    await page.getByRole("link", { name: "󰐥 Sign Out" }).click();
});

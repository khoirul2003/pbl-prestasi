import { test, expect } from "@playwright/test";

test("test", async ({ page }) => {
    await page.goto("https://presken.my.id/login");
    await page.getByRole("textbox", { name: "Username / NIP / NIM" }).click();
    await page
        .getByRole("textbox", { name: "Username / NIP / NIM" })
        .fill("admin");
    await page.getByRole("textbox", { name: "Password" }).click();
    await page.getByRole("textbox", { name: "Password" }).fill("Admin123!");
    await page.getByRole("button", { name: "SIGN IN" }).click();
    await page
        .getByText(
            "Students 28 Supervisors 15 Competitions 12 Achievements 21 Achievement Count by"
        )
        .click();
});

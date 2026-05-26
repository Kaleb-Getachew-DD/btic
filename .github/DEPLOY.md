# GitHub Actions → cPanel Production Deploy

This repo deploys to cPanel over **FTP** when you push to `main` (or run the workflow manually).

## 1. Add GitHub Secrets (required)

Open: **GitHub repo → Settings → Secrets and variables → Actions → New repository secret**

| Secret name   | Example value              | Notes |
|---------------|----------------------------|--------|
| `SERVER`      | `ftp.yourdomain.com`       | FTP host from cPanel (not `https://`) |
| `USERNAME`    | `cpanel_user`              | FTP username |
| `PASSWORD`    | `your-ftp-password`        | FTP password |
| `SERVER_DIR`  | `/public_html/` or `/public_html/btic/` | Remote folder path (must end with `/`) |
| `PORT`        | `21`                       | Optional; default is 21 |

Without these three (minimum: `SERVER`, `USERNAME`, `PASSWORD`), the workflow **fails immediately**.

## 2. Check the workflow run

1. Go to **Actions** tab on GitHub.
2. Open **Publish Website to CPanel**.
3. Click the latest run:
   - **Green** = files uploaded; check the site (may still need server steps below).
   - **Red** = open the failed step and read the log (wrong FTP host, login, or path).

### Run deploy manually

**Actions → Publish Website to CPanel → Run workflow → Run workflow**

Use this after fixing secrets or when you want to redeploy without a new commit.

## 3. Laravel on cPanel (one-time server setup)

FTP only uploads files. You still need on the server:

1. **`.env`** in the project root (create in cPanel File Manager; never commit to Git).
2. **Document root** must point to the `public` folder, e.g.:
   - App in `/home/user/btic/` → domain document root = `/home/user/btic/public`
   - Or symlink `public_html` → `btic/public` (ask hosting support if unsure).
3. After first deploy, in cPanel Terminal or SSH:
   ```bash
   cd ~/path/to/btic
   php artisan key:generate   # only if APP_KEY empty
   php artisan migrate --force
   php artisan storage:link
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   chmod -R 775 storage bootstrap/cache
   ```
4. **MySQL** database created in cPanel and credentials set in `.env`.

## 4. Common failures

| Symptom | Fix |
|---------|-----|
| Workflow does not start | Workflow file must be on `main`; push this repo or merge to `main`. |
| `Login authentication failed` | Wrong `USERNAME` / `PASSWORD` or FTP not enabled in cPanel. |
| `Could not connect to server` | Wrong `SERVER`; try IP or `ftp.domain.edu.et`. |
| Deploy succeeds but site unchanged | Wrong `SERVER_DIR`; files went to another folder. |
| 500 error after deploy | Missing `.env`, `vendor`, or document root not set to `public`. |
| CSS/JS old on live site | Hard refresh browser; confirm `public/css/app.css` exists on server. |

## 5. Pushing code does not update production until

- [ ] Secrets are set in GitHub
- [ ] Actions run is **successful** (green)
- [ ] `SERVER_DIR` matches your real upload path
- [ ] Server `.env` and Laravel caches are configured

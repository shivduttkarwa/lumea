param(
    [Parameter(Position = 0)]
    [string]$Message
)

if (-not $Message) {
    Write-Host "Enter commit message: " -NoNewline -ForegroundColor Green
    $Message = Read-Host
}

if ([string]::IsNullOrWhiteSpace($Message)) {
    Write-Error "Commit message is required."
    exit 1
}

git rev-parse --is-inside-work-tree *> $null
if ($LASTEXITCODE -ne 0) {
    Write-Error "This folder is not a Git repository."
    exit 1
}

git add -A
$stagedFiles = git diff --cached --name-only
if (-not $stagedFiles) {
    Write-Host "No changes to commit."
    exit 0
}

git commit -m $Message
if ($LASTEXITCODE -ne 0) {
    exit $LASTEXITCODE
}

$currentBranch = (git branch --show-current).Trim()
if ([string]::IsNullOrWhiteSpace($currentBranch)) {
    Write-Error "Unable to detect current branch."
    exit 1
}

git rev-parse --abbrev-ref "$currentBranch@{upstream}" *> $null
if ($LASTEXITCODE -eq 0) {
    git push
} else {
    git push -u origin $currentBranch
}

if ($LASTEXITCODE -eq 0) {
    Write-Host "Success: commit pushed to origin/$currentBranch." -ForegroundColor Green
}

exit $LASTEXITCODE

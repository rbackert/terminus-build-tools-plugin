#!/bin/bash

set -e

# Repair the test project on github
terminus build:project:repair -n "$TERMINUS_SITE" --email="$GIT_EMAIL"

cd "$TARGET_REPO_WORKING_COPY"

CI_PROVIDER=$1

if [[ "$CI_PROVIDER" == "gitlab" ]]; then
    TOKEN=$GITLAB_TOKEN
    ORIGIN="https://gitlab-ci-token:$GITLAB_TOKEN@gitlab.com/$GITLAB_USER/$TERMINUS_SITE.git"
if [[ "$CI_PROVIDER" == "bitbucket" ]]
    #ORIGIN="https://$GITHUB_TOKEN:x-oauth-basic@github.com/$GITHUB_USER/$TERMINUS_SITE.git"
else
    TOKEN=$GITHUB_TOKEN
    ORIGIN="https://$GITHUB_TOKEN:x-oauth-basic@github.com/$GITHUB_USER/$TERMINUS_SITE.git"
fi

git remote set-url origin $ORIGIN 2>&1 | sed -e "s/$TOKEN/[REDACTED]/g"

# A helper function to create a branch and pull request
function createBranchandPR()
{
    TEST_BRANCH_NAME="$1"
    TEST_COMMENT="$2"

    echo -e "Creating new pull request from branch $TEST_BRANCH_NAME"

    # Make a branch so for our test commit
    git checkout -b "$TEST_BRANCH_NAME" master

    # Add a comment to the README so that we know what this PR was made for
    echo "$TEST_COMMENT" >> "$TARGET_REPO_WORKING_COPY/README.md"
    git add README.md
    git commit -m "$TEST_COMMENT"

    # Push the branch
    git push -u origin "$TEST_BRANCH_NAME" 2>&1 | sed -e "s/$TOKEN/[REDACTED]/g"

    # Create the pull request
    terminus -n project:pull-request:create $TERMINUS_SITE --target=master --title="$TEST_COMMENT" --source="$TEST_BRANCH_NAME"

    # Back to master
    git checkout master
}

# Make a pull request to actually run tests
createBranchandPR 'test-after-repair' "Test after repair"

# Create a bunch of pull requests that will not run any tests.
# We do this so that we'll have to make more than one API request
# to find our test PR in order to test pagination.
for n in $(seq 1 12) ; do
    createBranchandPR "no-op-$n" "[ci skip] Pull request that is not tested (#$n)"
done
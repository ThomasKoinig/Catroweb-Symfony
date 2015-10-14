@homepage
Feature: As a visitor I want to see a program page

  Background:
    Given there are users:
      | name     | password | token      | email               |
      | Superman | 123456   | cccccccccc | dev1@pocketcode.org |
      | Gregor   | 123456   | cccccccccc | dev2@pocketcode.org |
    And there are programs:
      | id | name      | description             | owned by | downloads | apk_downloads | views | upload time      | version | language version | visible | apk_ready |
      | 1  | program 1 | my superman description | Superman | 3         | 2             | 12    | 01.01.2013 12:00 | 0.8.5   | 0.94             |  true   | true      |
      | 2  | program 2 | abcef                   | Gregor   | 333       | 3             | 9     | 22.04.2014 13:00 | 0.8.5   | 0.93             |  true   | true      |

    Scenario: Viewing program page
      Given I am on "/pocketcode/program/1"
      Then I should see "program 1"
      And I should see "Superman"
      And I should see "my superman description"
      And I should see "Report as inappropriate"
      And I should see "Catrobat Language version: 0.94"
      And I should see "more than one year ago"
      And I should see "0.00 MB"
      And I should see "5 downloads"
      And I should see "13 views"

    Scenario: Viewing the uploader's profile page
      Given I am on "/pocketcode/program/1"
      And I click "#program-user a"
      Then I should be on "/pocketcode/profile/1"

    Scenario: report as inapropriate
      Given I am on "/pocketcode/program/1"
      And I click "#report"
      Then I should see "Please login to report this program as inappropriate."
      When I click "#report-container a"
      Then I should be on "/pocketcode/login"
      And I fill in "username" with "Gregor"
      And I fill in "password" with "123456"
      And I press "Login"
      Then I should be on "/pocketcode/program/1#login"
      When I click "#report"
      Then I should see "Why do you think this program is inappropriate?"
      And I fill in "reportReason" with "I do not like this program ... hehe"
      When I click "#report-report"
      And I wait for the server response
      Then I should see "You reported this program as inappropriate!"

    Scenario: I want a link to this program
      Given I am on "/pocketcode/program/1"
      Then the element "#copy-link input" should not be visible
      When I click "#copy-link"
      Then the element "#copy-link input" should be visible
      And the element "#copy-link tr:nth-child(1)" should not be visible
      And the copy link should be "pocketcode/program/1"

    Scenario: I want to download a program from the browser
      Given I am on "/pocketcode/program/1"
      Then the link of "download" should open "download"
      And the link of "image" should open "download"

    Scenario: I want to download a program from the app with the correct language version
      Given I am browsing with my pocketcode app
      And I am on "/pocketcode/program/2"
      Then the link of "download" should open "download"
      And the link of "image" should open "download"

    Scenario: I want to download a program from the app with an an old language version
      Given I am browsing with my pocketcode app
      And I am on "/pocketcode/program/1"
      Then the link of "download" should open "popup"
      And the link of "image" should open "popup"
      Then I click the program download button
      And I see the "update app" popup
      Then I click on the program popup background
      And I see not the "update app" popup
      Then I click the program image
      And I see the "update app" popup
      Then I click on the propgram popup button
      And I see not the "update app" popup

    Scenario: Increasing download counter after apk download
      Given I am on "/pocketcode/program/1"
      Then I should see "5 downloads"
      When I want to download the apk file of "program 1"
      Then I should receive the apk file
      And I am on "/pocketcode/program/1"
      Then I should see "6 downloads"

    Scenario: Increasing download counter after download
      Given I am on "/pocketcode/program/1"
      Then I should see "5 downloads"
      When I download "/pocketcode/download/1.catrobat"
      Then I should receive an application file
      When I am on "/pocketcode/program/1"
      Then I should see "6 downloads"
# org.ndi.contactnumbers

![Screenshot](/images/screenshot.png)

This very small extension add a new field to reports: "Phone numbers". This
field will list all phone numbers associated with a contact, rather than just
their primary number.

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.4+
* CiviCRM (4.7+)

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl org.ndi.contactnumbers@https://github.com/nditech/org.ndi.contactnumbers/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git)
repo for this extension and install it with the command-line tool
[cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/nditech/org.ndi.contactnumbers.git
cv en contactnumbers
```

## Usage

Enable the extension as usual.

When creating reports, a "Phone numbers" field now appears, alongside "Phone".
Include this field in your report to get a consolidated list of contact phone
numbers.

## Known Issues

* Phone extensions are not currently listed.

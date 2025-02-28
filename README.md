# VN Expert - Flatsome UX Builder Element

A WordPress plugin that adds a custom expert/team member element to the Flatsome UX Builder.

## Description

VN Expert extends Flatsome theme's UX Builder by adding a customizable expert/team member element. Perfect for displaying team members, speakers, or expert profiles with advanced layout options.

## Features

- Fully integrated with Flatsome UX Builder
- Responsive design
- Customizable options:
  - Multiple style variants
  - Custom padding
  - Image support
  - Biographical content
  - Job title
  - Custom CSS classes

## Requirements

- WordPress 5.0 or higher
- Flatsome Theme 3.0 or higher
- PHP 7.4 or higher

## Installation

1. Download the plugin zip file
2. Go to WordPress admin > Plugins > Add New
3. Click "Upload Plugin"
4. Upload the zip file
5. Activate the plugin

## Usage

### Using UX Builder

1. Open Flatsome's UX Builder
2. Look for "VN Expert" in the Content elements
3. Drag and drop into your page
4. Customize the following options:
   - Style (Normal, Center, Bold, Bold-Center)
   - Speaker Title
   - Name
   - Job Title
   - Image
   - Content

### Using Shortcode

```php
[vn_expert 
    style="normal"
    speaker="Giảng viên chính"
    title="Anh"
    name="Nguyễn Văn A"
    jobtitle="Business Manager"
    image="path/to/image.jpg"
]
Your content here
[/vn_expert]
```

## Options

| Option    | Type   | Default         | Description           |
|-----------|--------|----------------|-----------------------|
| style     | string | normal         | Layout style          |
| speaker   | string | Giảng viên chính| Speaker title         |
| title     | string | Anh            | Title prefix         |
| name      | string |                | Expert's name        |
| jobtitle  | string |                | Position/Job title   |
| image     | url    |                | Expert's photo       |

## Changelog

### 1.0.0
- Initial release
- Added basic expert element
- Integrated with Flatsome UX Builder
- Added style options
- Added responsive support

## Support

For support, please visit [WP Mastery Now](https://wpmasterynow.com)

## License

GPL v2 or later

## Credits

Developed by Van Nam
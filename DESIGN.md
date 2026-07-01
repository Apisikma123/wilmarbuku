---
name: Academic Excellence System
colors:
  surface: '#f8f9ff'
  surface-dim: '#d0dbed'
  surface-bright: '#f8f9ff'
  surface-container-lowest: '#ffffff'
  surface-container-low: '#eff4ff'
  surface-container: '#e6eeff'
  surface-container-high: '#dfe9fb'
  surface-container-highest: '#d9e3f6'
  on-surface: '#121c29'
  on-surface-variant: '#404941'
  inverse-surface: '#27313f'
  inverse-on-surface: '#eaf1ff'
  outline: '#707970'
  outline-variant: '#c0c9be'
  surface-tint: '#2a6a3f'
  primary: '#003215'
  on-primary: '#ffffff'
  primary-container: '#004b23'
  on-primary-container: '#79bb87'
  inverse-primary: '#93d6a0'
  secondary: '#7b5800'
  on-secondary: '#ffffff'
  secondary-container: '#fdc34d'
  on-secondary-container: '#715000'
  tertiary: '#003128'
  on-tertiary: '#ffffff'
  tertiary-container: '#00493d'
  on-tertiary-container: '#4bbea5'
  error: '#ba1a1a'
  on-error: '#ffffff'
  error-container: '#ffdad6'
  on-error-container: '#93000a'
  primary-fixed: '#aef2bb'
  primary-fixed-dim: '#93d6a0'
  on-primary-fixed: '#00210c'
  on-primary-fixed-variant: '#0b5229'
  secondary-fixed: '#ffdea6'
  secondary-fixed-dim: '#f7bd48'
  on-secondary-fixed: '#271900'
  on-secondary-fixed-variant: '#5d4200'
  tertiary-fixed: '#87f6dc'
  tertiary-fixed-dim: '#69d9c0'
  on-tertiary-fixed: '#00201a'
  on-tertiary-fixed-variant: '#005143'
  background: '#f8f9ff'
  on-background: '#121c29'
  surface-variant: '#d9e3f6'
typography:
  display-lg:
    fontFamily: Poppins
    fontSize: 48px
    fontWeight: '700'
    lineHeight: 56px
    letterSpacing: -0.02em
  headline-lg:
    fontFamily: Poppins
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
  headline-lg-mobile:
    fontFamily: Poppins
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  headline-md:
    fontFamily: Poppins
    fontSize: 24px
    fontWeight: '600'
    lineHeight: 32px
  body-lg:
    fontFamily: Poppins
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Poppins
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-md:
    fontFamily: Poppins
    fontSize: 14px
    fontWeight: '500'
    lineHeight: 20px
    letterSpacing: 0.01em
  label-sm:
    fontFamily: Poppins
    fontSize: 12px
    fontWeight: '600'
    lineHeight: 16px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 4px
  gutter-desktop: 24px
  margin-desktop: 80px
  gutter-mobile: 16px
  margin-mobile: 20px
  max-width: 1280px
---

## Brand & Style

The design system is rooted in the academic prestige and entrepreneurial spirit of Wilmar Business Indonesia Polytechnic. It balances institutional authority with modern accessibility to foster a "Nurturing Entrepreneurs" environment. 

The visual style is **Corporate / Modern** with a lean toward academic tradition. It utilizes generous whitespace to promote focus and clarity, paired with a structured grid that reflects the organized nature of a literacy hub. The overall mood is trustworthy, professional, and empowering, ensuring that students, faculty, and stakeholders feel the weight of educational excellence through a clean, digital-first interface.

## Colors

The palette is derived from the institutional colors of the Wilmar Polytechnic logo. 

- **Primary:** A deep forest green (#004b23) represents growth and stability. Use this for primary navigation, key action buttons, and institutional headers.
- **Secondary:** An earth gold (#b8860b) serves as the accent for high-importance highlights, success states, or prestigious markers.
- **Tertiary:** A brighter teal-green (#1b9c85) is used for secondary interactive elements and decorative accents.
- **Neutrals:** Slate Gray (#454f5e) is used for body text and UI borders to ensure maximum readability and professional contrast. Mint Wash (#EDF6EE) and Surface Gray are utilized for section backgrounds to create a layered, organized depth.

## Typography

This design system uses **Poppins** across all levels to create a clean, modern, and highly legible geometric sans-serif aesthetic. 

- **Headlines:** Bold weights of Poppins provide a structured, professional feel for all page titles and section headers. This replaces the previous serif font to favor a more modern, streamlined institutional identity.
- **Body:** Regular weights of Poppins provide exceptional legibility for all long-form content on digital screens.
- **Labels/UI:** Poppins is also used for functional UI elements like navigation, buttons, and form labels, offering a neutral and efficient character.

Maintain a vertical rhythm by adhering to the defined line heights. Large headlines should use tighter tracking to maintain a cohesive visual block.

## Layout & Spacing

The layout follows a **Fixed Grid** philosophy to maintain a structured, book-like appearance on wider screens. 

- **Desktop (1280px+):** A 12-column grid with 24px gutters. Content is centered with a 1280px maximum width.
- **Tablet (768px - 1024px):** An 8-column grid with 24px gutters and 40px side margins.
- **Mobile (< 768px):** A 4-column grid with 16px gutters and 20px side margins.

Spacing follows a 4px base unit. Use generous padding (32px-64px) between major sections to emphasize the "organized" brand personality. Grouped elements within cards should use smaller increments (8px, 16px).

## Elevation & Depth

To maintain a professional and clean aesthetic, the design system uses **Tonal Layers** supplemented by **Ambient Shadows**.

- **Surfaces:** Use background color shifts (White to Mint Wash) to define content areas rather than heavy lines.
- **Shadows:** Shadows should be extremely subtle and diffused. Use a "Soft Lift" for cards and interactive components: `0px 4px 20px rgba(15, 23, 42, 0.05)`.
- **Interactions:** On hover, cards should increase their shadow spread slightly and shift upwards by 2px to provide tactile feedback without breaking the academic sobriety of the layout.

## Shapes

The design system uses a **Rounded** shape language (8px / 0.5rem base radius). This softens the "Corporate" feel and makes the platform more approachable for students.

- **Standard Elements:** Buttons and Input fields use the 8px base radius.
- **Large Elements:** Cards and containers use the `rounded-lg` (16px) radius to create a distinct containerized look.
- **Icons:** Use icons with slightly rounded terminals (e.g., Lucide or Phosphor in 'Regular' weight) to match the UI's roundedness.

## Components

### Buttons
- **Primary:** Solid Forest Green background with white text. High-contrast and authoritative.
- **Secondary:** Outline Earth Gold with Earth Gold text. Used for secondary CTAs.
- **Tertiary:** Ghost style with Slate Gray text, used for low-priority actions.

### Cards
- Catalog layouts should use white cards with an 8px border-radius and a subtle 1px border in a light gray.
- Headers within cards should use `headline-md` and body text `body-md`.
- Include a clear, consistent bottom-aligned CTA for catalog items (e.g., "View Details").

### Input Fields
- Use a light gray background (`surface-gray`) with a 1px border that turns Forest Green on focus.
- Labels must always be visible using `label-md` in Slate Gray.

### Chips & Tags
- Use for categories (e.g., "Entrepreneurship", "Case Study").
- Background: `mint-wash`; Text: `primary-color`. Rounded-full (pill) shape.

### Lists
- Academic data lists should use a subtle horizontal divider and increased vertical padding for high readability.
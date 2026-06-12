---
name: Industrial Luxe
colors:
  surface: '#141313'
  surface-dim: '#141313'
  surface-bright: '#3a3939'
  surface-container-lowest: '#0e0e0e'
  surface-container-low: '#1c1b1b'
  surface-container: '#201f1f'
  surface-container-high: '#2b2a2a'
  surface-container-highest: '#353434'
  on-surface: '#e5e2e1'
  on-surface-variant: '#c4c7c7'
  inverse-surface: '#e5e2e1'
  inverse-on-surface: '#313030'
  outline: '#8e9192'
  outline-variant: '#444748'
  surface-tint: '#c9c6c5'
  primary: '#c9c6c5'
  on-primary: '#313030'
  primary-container: '#0a0a0a'
  on-primary-container: '#7b7979'
  inverse-primary: '#5f5e5e'
  secondary: '#c8c6c5'
  on-secondary: '#313030'
  secondary-container: '#474746'
  on-secondary-container: '#b7b4b4'
  tertiary: '#f4bd6f'
  on-tertiary: '#452b00'
  tertiary-container: '#120800'
  on-tertiary-container: '#9e712b'
  error: '#ffb4ab'
  on-error: '#690005'
  error-container: '#93000a'
  on-error-container: '#ffdad6'
  primary-fixed: '#e5e2e1'
  primary-fixed-dim: '#c9c6c5'
  on-primary-fixed: '#1c1b1b'
  on-primary-fixed-variant: '#474646'
  secondary-fixed: '#e5e2e1'
  secondary-fixed-dim: '#c8c6c5'
  on-secondary-fixed: '#1c1b1b'
  on-secondary-fixed-variant: '#474746'
  tertiary-fixed: '#ffddb2'
  tertiary-fixed-dim: '#f4bd6f'
  on-tertiary-fixed: '#291800'
  on-tertiary-fixed-variant: '#624000'
  background: '#141313'
  on-background: '#e5e2e1'
  surface-variant: '#353434'
  gold-light: '#D4A95C'
  gold-dark: '#8C6526'
  cream-white: '#F5F2EC'
  stone-grey: '#8A8A8A'
typography:
  headline-xl:
    fontFamily: Montserrat
    fontSize: 64px
    fontWeight: '700'
    lineHeight: 72px
    letterSpacing: 0.05em
  headline-lg:
    fontFamily: Montserrat
    fontSize: 40px
    fontWeight: '600'
    lineHeight: 48px
    letterSpacing: 0.03em
  headline-md:
    fontFamily: Montserrat
    fontSize: 28px
    fontWeight: '600'
    lineHeight: 36px
  body-lg:
    fontFamily: Hanken Grotesk
    fontSize: 18px
    fontWeight: '400'
    lineHeight: 28px
  body-md:
    fontFamily: Hanken Grotesk
    fontSize: 16px
    fontWeight: '400'
    lineHeight: 24px
  label-caps:
    fontFamily: Montserrat
    fontSize: 12px
    fontWeight: '700'
    lineHeight: 16px
    letterSpacing: 0.15em
  headline-lg-mobile:
    fontFamily: Montserrat
    fontSize: 32px
    fontWeight: '600'
    lineHeight: 40px
rounded:
  sm: 0.25rem
  DEFAULT: 0.5rem
  md: 0.75rem
  lg: 1rem
  xl: 1.5rem
  full: 9999px
spacing:
  unit: 8px
  container-max: 1280px
  gutter: 24px
  margin-mobile: 16px
  margin-desktop: 64px
---

## Brand & Style

The design system is engineered to bridge the gap between heavy industrial paving and high-end architectural landscaping. It targets luxury villa owners, commercial developers, and public space planners in Konya and beyond. The brand personality is one of "Craftsmanship + Engineering"—where the raw durability of stone meets the precision of luxury design.

The chosen style is **Dark-Mode Minimalism with Glassmorphic Accents**. It leverages deep charcoal and anthracite surfaces to create a gallery-like environment where gold accents signify premium quality and architectural intent. The interface should feel sturdy yet sophisticated, using light and shadow to mimic the tactile quality of high-end pavement and stone textures.

**Visual Directives:**
- **Atmosphere:** Dark, quiet, and premium.
- **Graphic Motifs:** Utilize 1px stroke perspective lines (parallel pavement patterns) as subtle watermark textures in background containers to reinforce the "Zemin" (Floor/Ground) expertise.
- **Interactions:** Subtle "Gold Glow" transitions on hover to simulate light reflecting off polished stone or metallic finishes.

## Colors

This design system utilizes a high-contrast dark palette to evoke a sense of luxury and durability. The primary foundation is built on deep carbon tones, allowing the gold accents to emerge with architectural prominence.

- **Primary (Coal):** Used for main page backgrounds to ensure total immersion.
- **Secondary (Anthracite):** Used for elevated cards, sections, and navigation bars to provide structural depth.
- **Accent (Gold/Bronze):** The signature of craftsmanship. Used for primary actions, iconography, and decorative flourishes.
- **Neutral (Cream/Stone):** Text is never pure white; Cream-white provides a softer, high-end reading experience, while Stone-grey handles secondary information and metadata.

## Typography

The typography strategy balances authority with modern clarity. 

- **Headings:** Montserrat is selected as the alternative to Poppins for its geometric precision and wide letter-spacing capability, which conveys an architectural feel. Large headlines should use uppercase styling and wider tracking to mimic luxury branding.
- **Body:** Hanken Grotesk provides a technical, clean, and highly legible experience for long-form content, ensuring technical specifications and service descriptions remain professional.
- **Turkish Character Support:** Ensure all fonts are loaded with full Latin Extended support for characters like (ğ, ş, ı, İ, ç, ö, ü).

## Layout & Spacing

The layout follows a **Fixed Grid System** for desktop to maintain a gallery-like, curated feel, transitioning to a fluid layout for mobile devices.

- **Grid:** A 12-column grid is used for desktop (1280px max-width).
- **Rhythm:** An 8px base unit drives all padding and margin decisions. 
- **Section Spacing:** Generous vertical padding (96px to 128px) between sections to allow the high-quality project imagery to "breathe."
- **Breakpoints:**
  - **Mobile:** < 768px (1 column, 16px margins).
  - **Tablet:** 768px - 1024px (2 columns, 32px margins).
  - **Desktop:** > 1024px (12 columns, fixed width centered).

## Elevation & Depth

Visual hierarchy is achieved through a combination of **Tonal Layering** and **Glassmorphism**.

- **Surfaces:** Level 0 is the Coal (#0A0A0A) background. Level 1 is the Anthracite (#161616) surface for cards and navigation.
- **Glassmorphism:** Navigation bars and floating elements use a 15% opacity Anthracite fill with a 20px Backdrop Blur.
- **Shadows:** Shadows are "Atmospheric"—low opacity (40%), color-tinted with the Primary background color, and highly diffused (32px blur) to avoid a "cheap" floating look.
- **Hover States:** Instead of traditional elevation gain, use a "Gold Glow" effect—a subtle 1px inner border in #B6863E or an outer box-shadow with #B6863E at 20% opacity.

## Shapes

The design system uses a **Rounded** shape language to soften the industrial nature of the products. While the paving materials are hard stone, the digital interface should feel approachable and modern.

- **Standard Radius:** 0.5rem (8px) for buttons, small cards, and input fields.
- **Large Radius:** 1.5rem (24px) for major section containers and large imagery cards.
- **Pill:** Reserved exclusively for the WhatsApp floating button and small "status" tags.

## Components

### Buttons
- **Primary CTA:** Solid Gold (#B6863E) background with Coal (#0A0A0A) text. Bold Montserrat caps.
- **Secondary:** Outline Gold (#B6863E) with Cream-white text. 
- **Hover State:** Background shifts to Gold-light (#D4A95C) with a subtle outer glow.

### Cards & Comparison Sliders
- **Project Cards:** Anthracite background. On hover, the image scales slightly (1.05x) and a Gold bottom border (2px) appears.
- **Before/After Sliders:** A vertical gold handle (#B6863E) with a subtle "shimmer" animation.

### Navigation & Footer
- **Header:** Sticky, glassmorphic (blurred) background. Logo on the left, navigation centered, and a prominent "Teklif Al" (Get a Quote) Gold CTA on the right.
- **Footer:** 4-column layout (About, Services, Fast Links, Contact). Uses Stone-grey for non-essential links and Gold for the contact headers.

### Specialized Components
- **Floating WhatsApp:** Fixed at the bottom right. Green icon, but with a Gold pulse ripple effect to match the brand system.
- **Counters:** Large Montserrat numbers in Gold (#B6863E) with Stone-grey labels (e.g., "Tamamlanan Projeler").
- **Input Fields:** Anthracite background, 1px Stone-grey border, Gold border on focus.
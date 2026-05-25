---
name: design-system-l-oiseau-d
description: Creates implementation-ready design-system guidance with tokens, component behavior, and accessibility standards. Use when creating or updating UI rules, component specifications, or design-system documentation.
---

<!-- TYPEUI_SH_MANAGED_START -->

# L'OISEAU DÉ

## Mission
Deliver implementation-ready design-system guidance for L'OISEAU DÉ that can be applied consistently across documentation site interfaces.

## Brand
- Product/brand: L'OISEAU DÉ
- URL: https://loiseau.framer.website/
- Audience: developers and technical teams
- Product surface: documentation site

## Style Foundations
- Visual style: structured, accessible, implementation-first
- Main font style: `font.family.primary=Clash Display`, `font.family.stack=Clash Display, Clash Display Placeholder, sans-serif`, `font.size.base=32px`, `font.weight.base=500`, `font.lineHeight.base=44.8px`
- Typography scale: `font.size.xs=12px`, `font.size.sm=14px`, `font.size.md=16px`, `font.size.lg=24px`, `font.size.xl=32px`, `font.size.2xl=40px`, `font.size.3xl=48px`, `font.size.4xl=195.59px`
- Color palette: `color.surface.base=#000000`, `color.text.secondary=#483f36`, `color.text.tertiary=#0000ee`, `color.text.inverse=#c3e794`, `color.surface.muted=#ffffff`, `color.surface.raised=#486e46`, `color.surface.strong=#f0f7ed`
- Spacing scale: `space.1=6px`, `space.2=12px`, `space.3=16px`, `space.4=24px`, `space.5=32px`, `space.6=80px`, `space.7=120px`
- Radius/shadow/motion tokens: `motion.duration.instant=400ms`

## Accessibility
- Target: WCAG 2.2 AA
- Keyboard-first interactions required.
- Focus-visible rules required.
- Contrast constraints required.

## Writing Tone
concise, confident, implementation-focused

## Rules: Do
- Use semantic tokens, not raw hex values in component guidance.
- Every component must define required states: default, hover, focus-visible, active, disabled, loading, error.
- Responsive behavior and edge-case handling should be specified for every component family.
- Accessibility acceptance criteria must be testable in implementation.

## Rules: Don't
- Do not allow low-contrast text or hidden focus indicators.
- Do not introduce one-off spacing or typography exceptions.
- Do not use ambiguous labels or non-descriptive actions.

## Guideline Authoring Workflow
1. Restate design intent in one sentence.
2. Define foundations and tokens.
3. Define component anatomy, variants, and interactions.
4. Add accessibility acceptance criteria.
5. Add anti-patterns and migration notes.
6. End with QA checklist.

## Required Output Structure
- Context and goals
- Design tokens and foundations
- Component-level rules (anatomy, variants, states, responsive behavior)
- Accessibility requirements and testable acceptance criteria
- Content and tone standards with examples
- Anti-patterns and prohibited implementations
- QA checklist

## Component Rule Expectations
- Include keyboard, pointer, and touch behavior.
- Include spacing and typography token requirements.
- Include long-content, overflow, and empty-state handling.

## Quality Gates
- Every non-negotiable rule must use "must".
- Every recommendation should use "should".
- Every accessibility rule must be testable in implementation.
- Prefer system consistency over local visual exceptions.

<!-- TYPEUI_SH_MANAGED_END -->

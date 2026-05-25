# L'OISEAU DÉ

## Mission
Create implementation-ready, token-driven UI guidance for L'OISEAU DÉ that is optimized for consistency, accessibility, and fast delivery across documentation site.

## Brand
- Product/brand: L'OISEAU DÉ
- URL: https://loiseau.framer.website/
- Audience: developers and technical teams
- Product surface: documentation site

## Style Foundations
- Visual style: clean, functional, implementation-oriented
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
Concise, confident, implementation-focused.

## Rules: Do
- Use semantic tokens, not raw hex values, in component guidance.
- Every component must define states for default, hover, focus-visible, active, disabled, loading, and error.
- Component behavior should specify responsive and edge-case handling.
- Interactive components must document keyboard, pointer, and touch behavior.
- Accessibility acceptance criteria must be testable in implementation.

## Rules: Don't
- Do not allow low-contrast text or hidden focus indicators.
- Do not introduce one-off spacing or typography exceptions.
- Do not use ambiguous labels or non-descriptive actions.
- Do not ship component guidance without explicit state rules.

## Guideline Authoring Workflow
1. Restate design intent in one sentence.
2. Define foundations and semantic tokens.
3. Define component anatomy, variants, interactions, and state behavior.
4. Add accessibility acceptance criteria with pass/fail checks.
5. Add anti-patterns, migration notes, and edge-case handling.
6. End with a QA checklist.

## Required Output Structure
- Context and goals.
- Design tokens and foundations.
- Component-level rules (anatomy, variants, states, responsive behavior).
- Accessibility requirements and testable acceptance criteria.
- Content and tone standards with examples.
- Anti-patterns and prohibited implementations.
- QA checklist.

## Component Rule Expectations
- Include keyboard, pointer, and touch behavior.
- Include spacing and typography token requirements.
- Include long-content, overflow, and empty-state handling.
- Include known page component density: links (20), navigation (2), lists (2).

- Extraction diagnostics: Audience and product surface inference confidence is low; verify generated brand context.

## Quality Gates
- Every non-negotiable rule must use "must".
- Every recommendation should use "should".
- Every accessibility rule must be testable in implementation.
- Teams should prefer system consistency over local visual exceptions.

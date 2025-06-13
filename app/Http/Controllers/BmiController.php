<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BmiController extends Controller
{
    public function estimateBodyComposition($gender, $weight, $height, $age, $bmi)
    {
        $genderCode = $gender === 'male' ? 1 : 0;
        $bfp = (1.20 * $bmi) + (0.23 * $age) - (10.8 * $genderCode) - 5.4; # Body Fat Percentage (BFP) formula
        $fatMass = $weight * ($bfp / 100);

        $lbm = $weight * (1 - ($bfp / 100)); # Lean Body Mass (LBM) calculation
        $boneMass = 0.15 * $lbm; # Bone Mass estimation (15% of LBM)

        $genderCode = $gender === 'male' ? 1 : 2;
        $asm = 0.193 * $weight + 0.107 * $height - 4.157 * $genderCode - 0.037 * $age - 2.631; # Absolute Skeletal Muscle Mass (ASM) calculation

        $essentialFat = $gender === 'male' ? 0.05 * $weight : 0.12 * $weight;
        $storageFat = $fatMass - $essentialFat;
        $other = $lbm - $asm - $boneMass;

        return [
            'bfp' => round($bfp, 2),
            'fat_mass' => round($fatMass, 2),
            'lean_body_mass' => round($lbm, 2),
            'muscle_mass' => round($asm, 2),
            'bone_mass' => round($boneMass, 2),
            'essential_fat' => round($essentialFat, 2),
            'storage_fat' => round($storageFat, 2),
            'other' => round($other, 2)
        ];
    }

    public function calculate_bmi(Request $request)
    {
        return response()->json(['message' => 'BMI Route works'], 405);

        $validated = $request->validate([
            'gender' => 'required|string|in:male,female',
            'weight' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'age' => 'required|integer|min:0'
        ]);

        $weight = $request->input('weight');
        $height = $request->input('height')/100;

        if ($height <= 0) {
            return response()->json(['error' => 'Height must be greater than zero'], 400);
        }

        if ($weight <= 0) {
            return response()->json(['error' => 'Weight must be greater than zero'], 400);
        }

        $bmi = $weight / ($height ** 2);
        $bmi = round($bmi, 2);
        
        $category = match (true) {
            $bmi < 18.5 => 'Underweight',
            $bmi < 24.9 => 'Normal weight',
            $bmi < 29.9 => 'Overweight',
            default => 'Obese'
        };

        // if (Auth::check()) {
        //     Record::create([
        //         'userId' => Auth::id(),
        //         'weight' => $weight,
        //         'height' => $validated['height'],
        //         'bmi' => $bmi,
        //         'category' => $category
        //     ]);
        // }

        $composition = $this->estimateBodyComposition(
            $validated['gender'],
            $validated['weight'],
            $validated['height'],
            $validated['age'],
            $bmi
        );

        return response()->json([
            'gender' => $validated['gender'],
            'age' => $validated['age'],
            'weight' => $weight,
            'height' => $validated['height'],
            'bmi' => $bmi,
            'category' => $category,
            'composition' => $composition
        ]);
    }
}

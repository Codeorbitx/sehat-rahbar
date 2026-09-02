from flask import Flask, request, jsonify
import joblib
import numpy as np

app = Flask(__name__)

model = joblib.load('maternal_risk_model.pkl')
le = joblib.load('label_encoder.pkl')

@app.route('/predict', methods=['POST'])
def predict():
    data = request.get_json()

    try:
        features = np.array([[
            float(data['age']),
            float(data['systolic_bp']),
            float(data['diastolic_bp']),
            float(data['blood_sugar']),
            float(data['body_temp']),
            float(data['heart_rate']),
        ]])
    except (KeyError, ValueError) as e:
        return jsonify({'error': f'Invalid input: {str(e)}'}), 400

    prediction = model.predict(features)[0]
    risk_label = le.inverse_transform([prediction])[0]

    probabilities = model.predict_proba(features)[0]
    confidence = float(max(probabilities))

    return jsonify({
        'risk_level': risk_label,
        'confidence': round(confidence, 2)
    })

@app.route('/health', methods=['GET'])
def health():
    return jsonify({'status': 'ok'})

if __name__ == '__main__':
    app.run(port=5000, debug=True)